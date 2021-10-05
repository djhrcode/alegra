<?php

namespace App\Vote\Infrastructure\Persistence\Eloquent\Traits;

use App\Vote\Domain\Vote;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;

trait VoteTransformMethods
{
    private function useModel(): VoteModel
    {
        return new VoteModel;
    }

    private function transformToModel(Vote $seller): VoteModel
    {
        $voteModel = $this->useModel()->newInstance();
        $voteModel->id = $seller->id()->value();
        $voteModel->contest_id = $seller->contestId()->value();
        $voteModel->user_id = $seller->userId()->value();
        $voteModel->seller_id = $seller->sellerId()->value();

        return $voteModel;
    }

    private function transformToDomain(VoteModel $voteModel): Vote
    {
        return Vote::fromPrimitives(
            $voteModel->id,
            $voteModel->contest_id,
            $voteModel->user_id,
            $voteModel->seller_id
        );
    }
}
