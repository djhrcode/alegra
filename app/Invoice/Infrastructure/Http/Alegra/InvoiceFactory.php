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
            id: $this->array->get($data, 'id'),
            sellerId: $this->array->get($data, 'seller.id'),
            clientId: $this->array->get($data, 'client.id'),
            dueDate: $this->array->get($data, 'dueDate'),
            items: $items->all(),
            date: $this->array->get($data, 'date'),
            status: $this->array->get($data, 'status'),
            url: $this->array->get($data, 'pdf'),
        );

        return $invoice;
    }
}
