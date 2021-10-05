<?php

namespace App\Images\Domain;

use App\Shared\Domain\CollectionInterface;
use App\Shared\Domain\PaginationContext;

class ImageCollection implements CollectionInterface
{
    private PaginationContext $pagination;
    private array $items;

    public function __construct(PaginationContext $pagination, Image ...$items)
    {
        $this->pagination = $pagination;
        $this->items = $items;
    }

    public function paginator(): PaginationContext
    {
        return $this->pagination;
    }

    public function all(): array
    {
        return $this->items;
    }
}
