<?php

namespace App\Contest\Infrastructure\Persistence\Eloquent;

use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestRepository as ContestRepositoryInterface;
use App\Contest\Domain\ContestResult;
use App\Contest\Domain\ContestResultCollection;
use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestResultPosition;
use App\Contest\Domain\ValueObjects\ContestResultWinnerId;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Invoice\Domain\ValueObjects\InvoiceId;
use App\Seller\Domain\Seller;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use Illuminate\Database\Eloquent\Builder;

class ContestRepository implements ContestRepositoryInterface
{
    public function __construct(
        private ContestModel $model,
        private SellerModel $seller
    ) {
    }

    private function newBaseQuery(): Builder
    {
        return $this->model->newQuery()->withCount(['votes']);
    }


    public function find(ContestId $contestId): ?Contest
    {
        $contestFound = $this->newBaseQuery()->find($contestId->value());

        if (is_null($contestFound))
            return null;

        return Contest::fromPrimitives(
            $contestFound->id,
            $contestFound->name,
            $contestFound->status,
            $contestFound->votes_count,
            $contestFound->winner_id
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

    public function close(ContestId $contestId, SellerId $winnerId, InvoiceId $invoiceId): void
    {
        /**
         * @var ContestModel
         */
        $contestModel = $this->model->newQuery()->findOrFail($contestId->value());
        $contestModel->setWinner($winnerId->value());
        $contestModel->setInvoiceId($invoiceId->value());
        $contestModel->setStatus(ContestStatus::CLOSED);

        $contestModel->saveOrFail();
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
        $contest = $this->find($contestId);
        $sellers = $this->seller->newQuery()
            ->withCount([
                'votes' => fn (Builder $query) => $query->where('contest_id', $contestId->value()),
            ])
            ->orderBy('votes_count', 'desc')
            ->take(10)->get();


        $contestResults = $sellers->map(
            fn (SellerModel $sellerModel, int $index) => new ContestResult(
                ContestResultPosition::fromValue($index + 1),
                ContestResultWinnerId::fromValue($contest->winnerId()?->value() ?? -1),
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
