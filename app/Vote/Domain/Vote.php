<?php

namespace App\Vote\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Seller\Domain\ValueObjects\SellerId;
use App\User\Domain\ValueObjects\UserId;
use App\Vote\Domain\ValueObjects\VoteId;

final class Vote
{
    public function __construct(
        private VoteId $id,
        private ContestId $contestId,
        private UserId $userId,
        private SellerId $sellerId
    ) {
    }

    public function id(): VoteId
    {
        return $this->id;
    }

    public function contestId(): ContestId
    {
        return $this->contestId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function sellerId(): SellerId
    {
        return $this->sellerId;
    }

    public static function fromPrimitives(
        int $id,
        int $contestId,
        int $userId,
        int $sellerId
    ): static {
        return new static(
            VoteId::fromValue($id),
            ContestId::fromValue($contestId),
            UserId::fromValue($userId),
            SellerId::fromValue($sellerId),
        );
    }
}
