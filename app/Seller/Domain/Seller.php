<?php

namespace App\Seller\Domain;

use App\Seller\Domain\ValueObjects\SellerAlegraId;
use App\Seller\Domain\ValueObjects\SellerAvatar;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Seller\Domain\ValueObjects\SellerName;
use App\Seller\Domain\ValueObjects\SellerPoints;
use App\Seller\Domain\ValueObjects\SellerRemainingPoints;
use App\Seller\Domain\ValueObjects\SellerVotes;
use App\Seller\Domain\ValueObjects\SellerWinningPoints;

final class Seller
{

    public function __construct(
        private SellerId $id,
        private SellerName $name,
        private SellerAvatar $avatar,
        private SellerVotes $votes,
        private ?SellerAlegraId $alegraId = null
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $avatar,
        int $votes,
        ?int $alegraId = null,
    ) {
        return new static(
            SellerId::fromValue($id),
            SellerName::fromValue($name),
            SellerAvatar::fromValue($avatar),
            SellerVotes::fromValue($votes),
            $alegraId ? SellerAlegraId::fromValue($alegraId) : null
        );
    }

    public function winningPoints(): SellerWinningPoints
    {
        return app(SellerWinningPoints::class);
    }

    public function id(): SellerId
    {
        return $this->id;
    }

    public function name(): SellerName
    {
        return $this->name;
    }

    public function avatar(): SellerAvatar
    {
        return $this->avatar;
    }

    public function points(): SellerPoints
    {
        return $this->votes->toPoints();
    }

    public function totalPoints(): SellerPoints
    {
        return $this->votes->toPoints();
    }

    public function remainingPoints(): SellerRemainingPoints
    {
        return SellerRemainingPoints::fromPoints(
            $this->totalPoints(),
            $this->winningPoints()
        );
    }

    public function alegraId(): ?SellerAlegraId
    {
        return $this->alegraId;
    }
}
