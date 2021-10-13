<?php

namespace App\Seller\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Seller\Domain\ValueObjects\SellerId;
use App\User\Domain\ValueObjects\UserId;

interface SellerRepository
{
    public function find(SellerId $id): ?Seller;
    public function create(Seller $user): Seller;
    public function update(SellerId $sellerId, Seller $seller): void;
    public function delete(SellerId $id): void;
    public function upvote(UserId $upvoterId, SellerId $sellerId, ContestId $contestId): Seller;
    public function search(SellerSearchCriteria $criteria): SellerCollection;
}
