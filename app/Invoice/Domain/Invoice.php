<?php

namespace App\Invoice\Domain;

use App\Invoice\Domain\ValueObjects\InvoiceClientId;
use App\Invoice\Domain\ValueObjects\InvoiceDate;
use App\Invoice\Domain\ValueObjects\InvoiceDueDate;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Invoice\Domain\ValueObjects\InvoiceSellerId;
use App\Invoice\Domain\ValueObjects\InvoiceStatus;

final class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private InvoiceSellerId $sellerId,
        private InvoiceClientId $clientId,
        private InvoiceDueDate $dueDate,
        private ?InvoiceItemCollection $items = null,
        private ?InvoiceDate $date = null,
        private ?InvoiceStatus $status = null
    ) {
        $this->items = $items ?? InvoiceItemCollection::fromValue([]);
        $this->date = $date ?? InvoiceDate::fromValue(now());
        $this->status = $status ?? InvoiceStatus::fromValue(InvoiceStatus::DRAFT);
    }

    public static function fromPrimitives(
        int $id,
        int $sellerId,
        int $clientId,
        string $dueDate,
        array $items = [],
        ?string $date = null,
        ?string $status = null
    ): static {
        return new static(
            InvoiceId::fromValue($id),
            InvoiceSellerId::fromValue($sellerId),
            InvoiceClientId::fromValue($clientId),
            InvoiceDueDate::fromValue($dueDate),
            InvoiceItemCollection::fromValue($items),
            InvoiceDate::fromValue($date ?? now()),
            InvoiceStatus::fromValue($status ?? InvoiceStatus::DRAFT),
        );
    }

    public function id(): InvoiceId
    {
        return $this->id;
    }

    public function sellerId(): InvoiceSellerId
    {
        return $this->sellerId;
    }

    public function clientId(): InvoiceClientId
    {
        return $this->clientId;
    }

    public function dueDate(): InvoiceDueDate
    {
        return $this->dueDate;
    }

    public function date(): InvoiceDate
    {
        return $this->date;
    }

    public function status(): InvoiceStatus
    {
        return $this->status;
    }

    public function items(): InvoiceItemCollection
    {
        return $this->items;
    }
}
