<?php

namespace App\Seller\Application\Controllers;

use App\Images\Domain\Image;
use App\Images\Domain\ImageRepository;
use App\Images\Domain\ImageSearchCriteria;
use App\Seller\Application\Resources\SellerImageResource;
use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerImage;
use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\SellerSearchCriteria;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SellerImagesSearchController extends Controller
{
    public function __construct(
        private ImageRepository $images,
        private SellerRepository $sellers,
        private SerializerManager $manager,
        private SellerImageResource $resource
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $imageSearchCriteria = new ImageSearchCriteria(
            query: $request->query('query', null),
            page: $request->query('page', 1),
            per_page: $request->query('per_page', 20)
        );

        $sellerSearchCriteria = new SellerSearchCriteria(
            page: $request->query('page', 1),
            perPage: $request->query('per_page', 20),
        );

        $imageSearchResults = $this->images->search($imageSearchCriteria);
        $sellerSearchResults = $this->sellers->search($sellerSearchCriteria);

        /**
         * Since sometimes Unsplash could not return a higher or equal
         * amount of images for an specific search query, we need to
         * ensure that, depending on the smallest response, either images or sellers,
         * to use the smallest collection to return the search results
         */
        $areLessImagesThanSellers = count($sellerSearchResults->all()) > count($imageSearchResults->all());

        /**
         * We need to use the paginator of the smallest collection
         */
        $responsePaginator = $areLessImagesThanSellers
            ? $imageSearchResults->paginator()
            : $sellerSearchResults->paginator();

        $sellerImagesResults = $areLessImagesThanSellers
            ? $this->makeSellerImagesFromImages($imageSearchResults->all(), $sellerSearchResults->all())
            : $this->makeSellerImagesFromSellers($imageSearchResults->all(), $sellerSearchResults->all());

        return $this->manager->serialize(
            $this->resource
                ->makeCollection($sellerImagesResults->all())
                ->setPaginator($responsePaginator)
        );
    }

    private function makeSellerImagesFromImages(array $images, array $sellers): Collection
    {
        return collect($images)->map(
            fn (Image $image, int $index) => new SellerImage($image, $sellers[$index])
        );
    }

    private function makeSellerImagesFromSellers(array $images, array $sellers): Collection
    {
        return collect($sellers)->map(
            fn (Seller $seller, int $index) => new SellerImage($images[$index], $seller)
        );
    }
}
