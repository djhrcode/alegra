<?php

namespace App\Shared\Application\Resources;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

abstract class Resource extends TransformerAbstract
{
    public static function make(): self
    {
        return app(self::class);
    }

    public function makeItem($serializable): Item
    {
        return $this->item($serializable, $this);
    }

    public function makeCollection($serializable): Collection
    {
        return $this->collection($serializable, $this);
    }
}
