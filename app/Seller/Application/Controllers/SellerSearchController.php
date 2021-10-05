<?php

namespace App\Seller\Application\Controllers;

use App\Seller\Application\Resources\SellerResource;
use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\SellerSearchCriteria;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;

class SellerSearchController extends Controller
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
    public function __invoke(Request $request)
    {
        $criteria = new SellerSearchCriteria(
            $request->query('page', 1),
            $request->query('per_page', 10),
            $request->query('order_by', 'id'),
            $request->query('order_direction', 'desc')
        );

        $collection = $this->sellers->search($criteria);

        return $this->manager->serialize(
            $this->resource
                ->makeCollection($collection->all())
                ->setPaginator($collection->paginator())
        );
    }
}
