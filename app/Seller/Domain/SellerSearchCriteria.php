<?php

namespace App\Seller\Domain;

use Illuminate\Contracts\Support\Arrayable;

class SellerSearchCriteria
{
    public function __construct(
        private int $page = 1,
        private int $perPage = 10,
        private string $orderBy = 'id',
        private string $orderDirection = 'desc'
    ) {
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function orderBy(): string
    {
        return $this->orderBy;
    }

    public function orderDirection(): ?string
    {
        return $this->orderDirection;
    }
}
