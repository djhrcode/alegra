<?php

namespace App\Seller\Infrastructure\Persistence\Eloquent;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerCollection;
use App\Seller\Domain\SellerRepository as SellerRepositoryInterface;
use App\Seller\Domain\SellerSearchCriteria;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Seller\Infrastructure\Persistence\Eloquent\Traits\SellerTransformMethods;
use App\Setting\Domain\Contest\ContestActiveIdSetting;
use App\Shared\Domain\PaginationContext;
use App\User\Domain\User;
use App\User\Domain\ValueObjects\UserId;
use App\User\Infrastructure\Persistence\Eloquent\UserModel;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class SellerRepository implements SellerRepositoryInterface
{
    use SellerTransformMethods;

    public function __construct(
        private SellerModel $model,
        private VoteModel $vote,
        private ContestActiveIdSetting $activeContestId,
    ) {
    }

    private function newBaseQuery(): Builder
    {
        return $this->model->newQuery()->withCount([
            'votes' => fn (Builder $query) => $query->where('contest_id', $this->activeContestId->value()),
        ]);
    }

    public function upvote(UserId $upvoterId, SellerId $sellerId, ContestId $contestId): Seller
    {
        /**
         * @var SellerModel
         */
        $sellerModel = $this->model->findOrFail($sellerId->value());
        $voteModel = $this->vote->newInstance();

        $voteModel->seller()->associate($sellerId->value());
        $voteModel->user()->associate($upvoterId->value());
        $voteModel->contest()->associate($contestId->value());

        DB::transaction(fn () => $sellerModel->votes()->save($voteModel));

        $sellerModel = $this->newBaseQuery()->findOrFail($sellerId->value());

        return Seller::fromPrimitives(
            $sellerModel->id,
            $sellerModel->name,
            $sellerModel->avatar,
            $sellerModel->votes_count,
            $sellerModel->alegra_id,
        );
    }

    public function search(SellerSearchCriteria $criteria): SellerCollection
    {
        $paginator = $this->newBaseQuery()
            ->orderBy($criteria->orderBy(), $criteria->orderDirection())
            ->paginate(perPage: $criteria->perPage(), page: $criteria->page());

        $context = new PaginationContext(
            $paginator->perPage(),
            $paginator->total(),
            $paginator->lastPage(),
            $paginator->currentPage()
        );

        $results = collect($paginator->items())->map(
            fn (SellerModel $sellerModel) => $this->transformToDomain($sellerModel)
        );

        return new SellerCollection($context, ...$results->all());
    }

    public function find(SellerId $id): ?Seller
    {
        $sellerFound = $this->newBaseQuery()->find($id->value());

        if (is_null($sellerFound)) return null;

        return $this->transformToDomain($sellerFound);
    }

    public function create(Seller $seller): void
    {
        $sellerModel = $this->transformToModel($seller);

        $sellerModel->saveOrFail();
    }

    public function update(SellerId $sellerId, Seller $seller): void
    {
        /**
         * @var SellerModel
         */
        $sellerModel = $this->model
            ->newQueryWithoutScope($this->model::ONLY_SYNCED_SCOPE)
            ->findOrFail($sellerId->value());

        $sellerModel->updateOrFail([
            'name' => $seller->name()->value(),
            'avatar' => $seller->avatar()->value(),
            'alegra_id' => $seller->alegraId()->value(),
        ]);
    }

    public function delete(SellerId $id): void
    {
        $this->model->findOrFail($id->value())->delete();
    }
}
