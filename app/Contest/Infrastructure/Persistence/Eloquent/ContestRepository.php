<?php

namespace App\Contest\Infrastructure\Persistence\Eloquent;

use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestRepository as ContestRepositoryInterface;
use App\Contest\Domain\ContestResult;
use App\Contest\Domain\ContestResultCollection;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestResultPosition;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Seller\Domain\Seller;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use Illuminate\Database\Eloquent\Builder;

class ContestRepository implements ContestRepositoryInterface
{
    public function __construct(
        private ContestModel $model,
        private SellerModel $seller
    ) {
    }

    public function find(ContestId $contestId): ?Contest
    {
        $contestFound = $this->model->newQuery()->find($contestId->value());

        if (is_null($contestFound))
            return null;

        return Contest::fromPrimitives(
            $contestFound->id,
            $contestFound->name,
            $contestFound->status
        );
    }

    private function updateStatus(ContestId $contestId, ContestStatus $contestStatus): void
    {
        $contestFound = $this->model->newQuery()->findOrFail($contestId->value());

        $contestFound->updateOrFail(['status', $contestStatus->value()]);
    }

    public function open(ContestId $contestId): void
    {
        $this->updateStatus($contestId, ContestStatus::fromValue(ContestStatus::OPEN));
    }

    public function close(ContestId $contestId): void
    {
        $this->updateStatus($contestId, ContestStatus::fromValue(ContestStatus::CLOSED));
    }

    public function disable(ContestId $contestId): void
    {
        $this->updateStatus($contestId, ContestStatus::fromValue(ContestStatus::DISABLED));
    }

    public function create(Contest $contest): Contest
    {
        $contestModel = $this->model->newInstance();

        $contestModel->name = $contest->name()->value();
        $contestModel->status = $contest->status()->value();

        $contestModel->saveOrFail();

        return Contest::fromPrimitives(
            $contestModel->id,
            $contestModel->name,
            $contestModel->status
        );
    }


    public function results(ContestId $contestId): ContestResultCollection
    {
        $sellers = $this->seller->newQuery()
            ->withCount([
                'votes' => fn (Builder $query) => $query->where('contest_id', $contestId->value()),
            ])
            ->orderBy('votes_count', 'desc')
            ->take(10)->get();

        $contestResults = $sellers->map(
            fn (SellerModel $sellerModel, int $index) => new ContestResult(
                ContestResultPosition::fromValue($index + 1),
                Seller::fromPrimitives(
                    $sellerModel->id,
                    $sellerModel->name,
                    $sellerModel->avatar,
                    $sellerModel->votes_count,
                    $sellerModel->alegra_id,
                )
            )
        );

        return new ContestResultCollection(...$contestResults);
    }
}
