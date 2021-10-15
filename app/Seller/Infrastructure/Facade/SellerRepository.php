<?php

namespace App\Seller\Infrastructure\Facade;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerCollection;
use App\Seller\Domain\SellerRepository as SellerRepositoryInterface;
use App\Seller\Domain\SellerSearchCriteria;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Seller\Infrastructure\Http\Alegra\SellerRepository as AlegraSellerRepository;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerRepository as EloquentSellerRepository;
use App\Seller\Infrastructure\Persistence\Eloquent\Traits\SellerTransformMethods;
use App\User\Domain\ValueObjects\UserId;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class SellerRepository implements SellerRepositoryInterface
{
    use SellerTransformMethods;

    public function __construct(
        private Str $stringUtils,
        private SellerModel $sellerModel,
        private AlegraSellerRepository $alegraSellers,
        private EloquentSellerRepository $eloquentSellers
    ) {
    }

    public function find(SellerId $id): ?Seller
    {
        return $this->eloquentSellers->find($id);
    }

    public function delete(SellerId $id): void
    {
        $this->eloquentSellers->delete($id);
    }

    public function update(SellerId $sellerId, Seller $seller): void
    {
        $this->eloquentSellers->update($sellerId, $seller);
    }

    public function upvote(UserId $upvoterId, SellerId $sellerId, ContestId $contestId): Seller
    {
        return $this->eloquentSellers->upvote($upvoterId, $sellerId, $contestId);
    }

    public function create(Seller $user): Seller
    {
        return $this->eloquentSellers->create($user);
    }

    public function search(SellerSearchCriteria $criteria): SellerCollection
    {
        $sellers = $this->alegraSellers->search($criteria);
        $sellersCollection = collect($sellers->all());

        /**
         * @var Collection
         */
        $sellersIds = $sellersCollection->reduce(function (Collection $carry, Seller $seller) {
            return $carry->push($seller->id()->value());
        }, collect([]));

        /**
         * @var Collection
         */
        $localSellers = $this->eloquentSellers
            ->newBaseQuery()
            ->whereIn('alegra_id', $sellersIds)
            ->get()
            ->keyBy("alegra_id");

        $unsynchronizedSellers = collect([]);

        $synchronizedSellers = $sellersIds->reduceWithKeys(
            function (
                Collection $sellers,
                int $sellerId,
                int $sellerIndex
            ) use (
                $localSellers,
                $unsynchronizedSellers,
                $sellersCollection
            ) {
                if ($localSellers->has($sellerId))
                    return $sellers->put($sellerId, $localSellers->get($sellerId));

                $seller = $sellersCollection->get($sellerIndex);

                $unsynchronizedSellers->push([
                    'name' => $seller->name()->value(),
                    'avatar' => "https://i.pravatar.cc/150?u={$this->stringUtils->uuid()}",
                    'alegra_id' => $seller->alegraId()->value(),
                ]);

                return $sellers->put($sellerId, null);
            },
            collect([])
        );

        if ($unsynchronizedSellers->isEmpty()) {
            $results = collect($localSellers->values())->map(
                fn (SellerModel $sellerModel) => $this->transformToDomain($sellerModel)
            );

            return new SellerCollection($sellers->context(), ...$results->all());
        }

        if ($unsynchronizedSellers->isNotEmpty()) {
            $this->sellerModel
                ->newQuery()
                ->upsert($unsynchronizedSellers->all(), ['alegra_id'], ['name']);
        }

        $unsynchronizedSellersIds = $unsynchronizedSellers->pluck('alegra_id');

        /**
         * @var Collection
         */
        $nowSynchronizedSellers = $this->eloquentSellers
            ->newBaseQuery()
            ->whereIn('alegra_id', $unsynchronizedSellersIds)
            ->get()
            ->keyBy("alegra_id")
            ->merge($localSellers);

        $results = collect($nowSynchronizedSellers->values())->map(
            fn (SellerModel $sellerModel) => $this->transformToDomain($sellerModel)
        );

        return new SellerCollection($sellers->context(), ...$results->all());
    }
}
