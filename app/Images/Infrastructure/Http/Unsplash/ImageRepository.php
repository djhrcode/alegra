<?php

namespace App\Images\Infrastructure\Http\Unsplash;

use App\Images\Domain\Image;
use App\Images\Domain\ImageCollection;
use App\Images\Domain\ImageRepository as ImageRepositoryInterface;
use App\Images\Domain\ImageSearchCriteria;
use App\Shared\Domain\PaginationContext;
use App\Shared\Infrastructure\Http\Unsplash\UnsplashHttpClient;
use Illuminate\Support\Arr;

class ImageRepository implements ImageRepositoryInterface
{
    public function __construct(private UnsplashHttpClient $client)
    {
    }

    public function search(ImageSearchCriteria $criteria): ImageCollection
    {
        $response = $this->client->get("search/photos", $criteria->toArray());

        $response->throw();

        $jsonResponse = $response->json();

        $pagination = new PaginationContext(
            $criteria->per_page(),
            $jsonResponse['total'],
            $jsonResponse['total_pages'],
            $criteria->page()
        );

        $results = collect($jsonResponse['results'])->map(fn (array $image) => Image::fromPrimitives(
            Arr::get($image, 'id'),
            Arr::get($image, 'height'),
            Arr::get($image, 'width'),
            Arr::get($image, 'urls'),
            Arr::get($image, 'color'),
            Arr::get($image, 'description')
        ))->all();

        return new ImageCollection($pagination, ...$results);
    }
}
