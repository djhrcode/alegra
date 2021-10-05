<?php

namespace App\Seller\Domain;

use App\Shared\Domain\CollectionInterface;
use App\Shared\Domain\PaginationContext;

class SellerCollection implements CollectionInterface
{
    private PaginationContext $context;
    private array $items;

    public function __construct(PaginationContext $context, Seller ...$items)
    {
        $this->context = $context;
        $this->items = $items;
    }

    public function context(): PaginationContext
    {
        return $this->context;
    }

    public function paginator(): PaginationContext
    {
        return $this->context;
    }

    public function all(): array
    {
        return $this->items;
    }
}
