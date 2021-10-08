<?php

namespace App\Invoice\Infrastructure\Http\Alegra;

use App\Invoice\Domain\Invoice;
use App\Invoice\Domain\InvoiceItem;

class InvoiceJsonDataFactory
{
    public function create(Invoice $invoice): array
    {
        return [
            'id' => $invoice->id()->value(),
            'dueDate' => $invoice->dueDate()->value(),
            'date' => $invoice->date()->value(),
            'client' => $invoice->clientId()->value(),
            'seller' => $invoice->sellerId()->value(),
            'status' => $invoice->status()->value(),

            'items' => collect($invoice->items()->all())
                ->map(fn (InvoiceItem $item) => [
                    'id' => $item->id()->value(),
                    'description' => $item->description()->value(),
                    'price' => $item->price()->value(),
                    'quantity' => $item->quantity()->value(),
                ])->all(),
        ];
    }
}
