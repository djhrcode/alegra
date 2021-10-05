<?php

namespace App\Seller\Domain;

use App\Images\Domain\Image;
use App\Images\Domain\ValueObjects\ImageColor;
use App\Images\Domain\ValueObjects\ImageDescription;
use App\Images\Domain\ValueObjects\ImageHeight;
use App\Images\Domain\ValueObjects\ImageId;
use App\Images\Domain\ValueObjects\ImageUrlsMap;
use App\Images\Domain\ValueObjects\ImageWidth;

final class SellerImage
{
    public function __construct(
        private Image $image,
        private Seller $seller
    ) {
    }

    public function seller(): Seller
    {
        return $this->seller;
    }

    public function id(): ImageId
    {
        return $this->image->id();
    }

    public function description(): ?ImageDescription
    {
        return $this->image->description();
    }

    public function height(): ImageHeight
    {
        return $this->image->height();
    }

    public function width(): ImageWidth
    {
        return $this->image->width();
    }

    public function urls(): ImageUrlsMap
    {
        return $this->image->urls();
    }

    public function color(): ImageColor
    {
        return $this->image->color();
    }
}
