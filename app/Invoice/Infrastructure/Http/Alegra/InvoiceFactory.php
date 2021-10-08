<?php

namespace App\Invoice\Infrastructure\Http\Alegra;

use App\Invoice\Domain\Invoice;
use App\Invoice\Domain\InvoiceItem;
use Illuminate\Support\Arr;

class InvoiceFactory
{
    public function __construct(private Arr $array)
    {
    }

    public function create(array $data): Invoice
    {
        $items = collect($this->array->get($data, 'items'))
            ->map(
                fn (array $itemData) => InvoiceItem::fromPrimitives(
                    $this->array->get($itemData, 'id'),
                    $this->array->get($itemData, 'price'),
                    $this->array->get($itemData, 'description'),
                    $this->array->get($itemData, 'quantity'),
                )
            );

        $invoice = Invoice::fromPrimitives(
            $this->array->get($data, 'id'),
            $this->array->get($data, 'seller.id'),
            $this->array->get($data, 'client.id'),
            $this->array->get($data, 'dueDate'),
            $items->all(),
            $this->array->get($data, 'date'),
            $this->array->get($data, 'status'),
        );

        return $invoice;
    }
}
