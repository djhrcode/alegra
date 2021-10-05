<?php

namespace App\Seller\Domain;

use App\Seller\Domain\ValueObjects\SellerId;

interface SellerRepository
{
    public function find(SellerId $id): ?Seller;
    public function create(Seller $user): void;
    public function update(SellerId $sellerId, Seller $seller): void;
    public function delete(SellerId $id): void;
    public function search(SellerSearchCriteria $criteria): SellerCollection;
}
