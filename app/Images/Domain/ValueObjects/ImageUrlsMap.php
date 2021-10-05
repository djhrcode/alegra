<?php

namespace App\Images\Domain\ValueObjects;

use Illuminate\Support\Arr;

final class ImageUrlsMap
{
    public function __construct(
        private ImageUrl $raw,
        private ImageUrl $full,
        private ImageUrl $regular,
        private ImageUrl $small,
        private ImageUrl $thumb
    ) {
    }

    public static function fromValue(array $urls): static
    {
        return new static(
            ImageUrl::fromValue(Arr::get($urls, 'raw')),
            ImageUrl::fromValue(Arr::get($urls, 'full')),
            ImageUrl::fromValue(Arr::get($urls, 'regular')),
            ImageUrl::fromValue(Arr::get($urls, 'small')),
            ImageUrl::fromValue(Arr::get($urls, 'thumb'))
        );
    }

    public function raw(): ImageUrl
    {
        return $this->raw;
    }

    public function full(): ImageUrl
    {
        return $this->full;
    }

    public function regular(): ImageUrl
    {
        return $this->regular;
    }

    public function small(): ImageUrl
    {
        return $this->small;
    }

    public function thumb(): ImageUrl
    {
        return $this->thumb;
    }
}
