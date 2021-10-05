<?php

namespace App\Shared\Domain;

abstract class Collection implements CollectionInterface
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }
}
