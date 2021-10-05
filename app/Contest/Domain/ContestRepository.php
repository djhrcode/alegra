<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;

interface ContestRepository
{
    public function find(ContestId $contestId): ?Contest;
    public function create(Contest $contest): Contest;
    public function close(ContestId $contestId): void;
    public function open(ContestId $contestId): void;
    public function results(ContestId $contestId): ContestResultCollection;
}
