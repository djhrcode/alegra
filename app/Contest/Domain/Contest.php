<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestInvoiceUrl;
use App\Contest\Domain\ValueObjects\ContestName;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Contest\Domain\ValueObjects\ContestTotalPoints;
use App\Contest\Domain\ValueObjects\ContestVotes;
use App\Contest\Domain\ValueObjects\ContestWinnerId;

final class Contest
{
    public function __construct(
        private ContestId $id,
        private ContestName $name,
        private ContestStatus $status,
        private ContestVotes $votes,
        private ?ContestWinnerId $winnerId = null,
        private ?ContestInvoiceUrl $invoiceUrl = null,
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $status,
        int $votes = 0,
        ?int $winnerId = null,
        ?string $invoiceUrl = null
    ): static {
        return new static(
            ContestId::fromValue($id),
            ContestName::fromValue($name),
            ContestStatus::fromValue($status),
            ContestVotes::fromValue($votes),
            $winnerId ? ContestWinnerId::fromValue($winnerId) : null,
            $invoiceUrl ? ContestInvoiceUrl::fromValue($invoiceUrl) : null
        );
    }

    public function id(): ContestId
    {
        return $this->id;
    }

    public function name(): ContestName
    {
        return $this->name;
    }

    public function status(): ContestStatus
    {
        return $this->status;
    }

    public function totalPoints(): ContestTotalPoints
    {
        return $this->votes->toPoints();
    }

    public function winnerId(): ?ContestWinnerId
    {
        return $this->winnerId;
    }

    public function invoiceUrl(): ?ContestInvoiceUrl
    {
        return $this->invoiceUrl;
    }
}
