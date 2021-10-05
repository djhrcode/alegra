<?php

namespace App\Contest\Application\Controllers;

use App\Contest\Application\Resources\ContestResultResource;
use App\Contest\Domain\ContestRepository;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use Illuminate\Http\Request;

class ContestResultsListController extends Controller
{
    public function __construct(
        private ContestRepository $contests,
        private SerializerManager $manager,
        private ContestResultResource $resource
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $contest)
    {
        $results = $this->contests->results(ContestId::fromValue($contest));

        return $this->manager->serialize(
            $this->resource->makeCollection($results->all())
        );
    }
}
