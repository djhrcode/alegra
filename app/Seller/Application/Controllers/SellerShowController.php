<?php

namespace App\Seller\Application\Controllers;

use App\Seller\Application\Resources\SellerResource;
use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;

class SellerShowController extends Controller
{
    public function __construct(
        private SellerRepository $sellers,
        private SerializerManager $manager,
        private SellerResource $resource
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $sellerId)
    {
        $seller = $this->sellers->find(SellerId::fromValue($sellerId));

        return $this->manager->serialize(
            $this->resource->makeItem($seller)
        );
    }
}
