<?php

namespace App\Invoice\Infrastructure\Http\Alegra;

use App\Invoice\Domain\Invoice;
use App\Invoice\Domain\InvoiceRepository as InvoiceRepositoryInterface;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Shared\Infrastructure\Http\Alegra\AlegraHttpClient;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private AlegraHttpClient $httpClient,
        private InvoiceFactory $invoiceFactory,
        private InvoiceJsonDataFactory $invoiceJsonFactory,
    ) {
    }

    public function find(InvoiceId $id): ?Invoice
    {
        $response = $this->httpClient->get("invoices/{$id->value()}", ['fields' => 'pdf']);
        $response->throw();

        dump($response->json());

        return $this->invoiceFactory->create($response->json());
    }

    public function create(Invoice $invoice): Invoice
    {
        $response = $this->httpClient->post(
            "invoices",
            $this->invoiceJsonFactory->create($invoice)
        );
        $response->throw();

        return $this->invoiceFactory->create($response->json());
    }
}
