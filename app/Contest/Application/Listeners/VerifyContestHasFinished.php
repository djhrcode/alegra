<?php

namespace App\Contest\Application\Listeners;

use App\Contest\Domain\ContestRepository;
use App\Invoice\Domain\Invoice;
use App\Invoice\Domain\InvoiceItem;
use App\Invoice\Domain\InvoiceItemCollection;
use App\Invoice\Domain\InvoiceRepository;
use App\Invoice\Domain\ValueObjects\InvoiceClientId;
use App\Invoice\Domain\ValueObjects\InvoiceDate;
use App\Invoice\Domain\ValueObjects\InvoiceDueDate;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Invoice\Domain\ValueObjects\InvoiceItemDescription;
use App\Invoice\Domain\ValueObjects\InvoiceItemId;
use App\Invoice\Domain\ValueObjects\InvoiceItemPrice;
use App\Invoice\Domain\ValueObjects\InvoiceItemQuantity;
use App\Invoice\Domain\ValueObjects\InvoiceSellerId;
use App\Invoice\Domain\ValueObjects\InvoiceStatus;
use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\ValueObjects\SellerWinningPoints;
use App\Setting\Domain\Contest\ContestActiveIdSetting;
use App\Vote\Domain\Events\VoteTransactionEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifyContestHasFinished
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private SellerRepository $sellers,
        private ContestRepository $contests,
        private InvoiceRepository $invoices,
        private ContestActiveIdSetting $contestActiveId,
        private SellerWinningPoints $winningPoints,
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VoteTransactionEvent $event)
    {
        $contestId = $event->vote()->contestId();
        $sellerId = $event->vote()->sellerId();

        if ($contestId->value() !== $this->contestActiveId->value())
            return;

        $seller = $this->sellers->find($sellerId);

        if ($seller->points()->value() < $this->winningPoints->value())
            return;

        $contest = $this->contests->find($contestId);

        $invoiceItem = new InvoiceItem(
            InvoiceItemId::fromValue(1),
            InvoiceItemPrice::fromValue(1000),
            InvoiceItemDescription::fromValue("Premio a ganador del concurso {$contest->name()->value()}"),
            InvoiceItemQuantity::fromValue($contest->totalPoints()->value()),
        );

        $invoice = $this->invoices->create(
            new Invoice(
                id: InvoiceId::fromValue(0),
                sellerId: InvoiceSellerId::fromValue($seller->alegraId()->value()),
                clientId: InvoiceClientId::fromValue(1),
                dueDate: InvoiceDueDate::fromDate(now()->addMonth()),
                date: InvoiceDate::fromDate(now()),
                status: InvoiceStatus::fromValue(InvoiceStatus::OPEN),
                items: InvoiceItemCollection::fromValue([$invoiceItem]),
            )
        );

        $invoiceCreated = $this->invoices->create($invoice);


        $this->contests->close($contestId, $sellerId, $invoiceCreated->id());
    }
}
