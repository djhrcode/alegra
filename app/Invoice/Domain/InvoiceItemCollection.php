<?php

namespace App\Invoice\Domain;

use App\Invoice\Domain\ValueObjects\InvoiceClientId;
use App\Invoice\Domain\ValueObjects\InvoiceDate;
use App\Invoice\Domain\ValueObjects\InvoiceDueDate;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Invoice\Domain\ValueObjects\InvoiceSellerId;
use App\Invoice\Domain\ValueObjects\InvoiceStatus;
use App\Shared\Domain\CollectionInterface;

final class InvoiceItemCollection implements CollectionInterface
{
    private array $items = [];

    public function __construct(InvoiceItem ...$items)
    {
        $this->items = $items;
    }

    public static function fromValue(array $items): static
    {
        return new static(...$items);
    }

    public function all(): array
    {
        return $this->items;
    }
}
