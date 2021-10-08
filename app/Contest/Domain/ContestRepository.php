<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Seller\Domain\ValueObjects\SellerId;

interface ContestRepository
{
    public function find(ContestId $contestId): ?Contest;
    public function create(Contest $contest): Contest;
    public function close(ContestId $contestId, SellerId $winnerId, InvoiceId $invoiceId): void;
    public function open(ContestId $contestId): void;
    public function results(ContestId $contestId): ContestResultCollection;
}
