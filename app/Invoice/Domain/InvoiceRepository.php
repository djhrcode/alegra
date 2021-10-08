<?php

namespace App\Invoice\Domain;

use App\Invoice\Domain\ValueObjects\InvoiceId;

interface InvoiceRepository
{
    public function find(InvoiceId $id): ?Invoice;
    public function create(Invoice $invoice): Invoice;
}
