<?php

namespace App\Images\Domain;

use App\Images\Domain\ValueObjects\ImageColor;
use App\Images\Domain\ValueObjects\ImageDescription;
use App\Images\Domain\ValueObjects\ImageHeight;
use App\Images\Domain\ValueObjects\ImageId;
use App\Images\Domain\ValueObjects\ImageUrlsMap;
use App\Images\Domain\ValueObjects\ImageWidth;

final class Image
{
    public function __construct(
        private ImageId $id,
        private ImageHeight $height,
        private ImageWidth $width,
        private ImageUrlsMap $urls,
        private ?ImageColor $color = null,
        private ?ImageDescription $description = null
    ) {
        $this->color ?? $this->color = ImageColor::fromValue("#0B0B0B");
    }

    public static function fromPrimitives(
        string $id,
        int $height,
        int $width,
        array $urls,
        string $color = "#0B0B0B",
        ?string $description = null
    ): static {
        return new static(
            ImageId::fromValue($id),
            ImageHeight::fromValue($height),
            ImageWidth::fromValue($width),
            ImageUrlsMap::fromValue($urls),
            ImageColor::fromValue($color),
            $description ? ImageDescription::fromValue($description) : null
        );
    }


    public function id(): ImageId
    {
        return $this->id;
    }

    public function description(): ?ImageDescription
    {
        return $this->description;
    }

    public function height(): ImageHeight
    {
        return $this->height;
    }

    public function width(): ImageWidth
    {
        return $this->width;
    }

    public function urls(): ImageUrlsMap
    {
        return $this->urls;
    }

    public function color(): ImageColor
    {
        return $this->color;
    }
}
