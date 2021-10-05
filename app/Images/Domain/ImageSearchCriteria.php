<?php

namespace App\Images\Domain;

use Illuminate\Contracts\Support\Arrayable;

class ImageSearchCriteria implements Arrayable
{
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';
    const ORIENTATION_SQUARISH = 'squarish';


    public function __construct(
        private string $query,
        private int $page = 1,
        private int $per_page = 10,
        private string $order_by = 'relevant',
        private ?string $orientation = null
    ) {
    }

    public function query(): string
    {
        return $this->query;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function per_page(): int
    {
        return $this->per_page;
    }

    public function order_by(): string
    {
        return $this->order_by;
    }

    public function orientation(): ?string
    {
        return $this->orientation;
    }

    public function toArray()
    {
        return [
            'query' => $this->query,
            'page' => $this->page,
            'per_page' => $this->per_page,
            'order_by' => $this->order_by,
            'orientation' => $this->orientation,
        ];
    }
}
