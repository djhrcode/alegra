<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
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
        private ?ContestWinnerId $winnerId = null
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $status,
        int $votes = 0,
        ?int $winnerId = null
    ): static {
        return new static(
            ContestId::fromValue($id),
            ContestName::fromValue($name),
            ContestStatus::fromValue($status),
            ContestVotes::fromValue($votes),
            ContestWinnerId::fromValue($winnerId ?? -1),
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
}
