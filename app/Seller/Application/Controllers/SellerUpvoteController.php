<?php

namespace App\Seller\Application\Controllers;

use App\Contest\Domain\ContestRepository;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Seller\Application\Resources\SellerResource;
use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use App\User\Domain\User;
use App\User\Domain\ValueObjects\UserId;
use Illuminate\Http\Request;

class SellerUpvoteController extends Controller
{
    public function __construct(
        private SellerRepository $sellers,
        private ContestRepository $contests,
        private SettingRepository $settings,
        private SerializerManager $manager,
        private SellerResource $resource
    ) {
        $this->middleware("auth:sanctum");
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $activeContestId = $this->settings->find(
            SettingName::fromValue(SettingName::CONTEST_ACTIVE_ID)
        );

        $sellerUpvoted = $this->sellers->upvote(
            UserId::fromValue($request->user()->id),
            SellerId::fromValue($request->route("seller")),
            ContestId::fromValue((int) $activeContestId->value()->value())
        );

        return $this->manager->serialize(
            $this->resource->makeItem($sellerUpvoted)
        );
    }
}
