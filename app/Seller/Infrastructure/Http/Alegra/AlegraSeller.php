<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class AlegraSeller implements Arrayable
{
    public function __construct(
        private int $id,
        private string $name,
        private string $status = 'active',
        private ?string $observations = null
    ) {
    }

    public static function new(
        int $id,
        string $name,
        string $status = 'active',
        ?string $observations = null
    ) {
        return new static($id, $name, $status, $observations);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function observations(): ?string
    {
        return $this->observations;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'status' => $this->status(),
            'observations' => $this->observations()
        ];
    }

    public static function fromArray(array $sellerArray)
    {
        return new static(
            Arr::get($sellerArray, 'id'),
            Arr::get($sellerArray, 'name'),
            Arr::get($sellerArray, 'status'),
            Arr::get($sellerArray, 'observations')
        );
    }
}
