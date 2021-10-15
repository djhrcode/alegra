<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerCollection;
use App\Shared\Domain\PaginationContext;

final class SellerCollectionFactory
{
    public function __construct(private SellerFactory $sellerFactory)
    {
    }

    public function create(array $sellers, PaginationContext $context): SellerCollection
    {
        $items = collect($sellers)
            ->map(fn (array $seller) => $this->sellerFactory->create($seller))
            ->all();

        return new SellerCollection($context, ...$items);
    }
}
