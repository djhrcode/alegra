<?php

namespace App\Seller\Infrastructure\Persistence\Eloquent\Traits;

use App\Seller\Domain\Seller;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;

trait SellerTransformMethods
{
    private function transformToModel(Seller $seller): SellerModel
    {
        $sellerModel = $this->model->newInstance();
        $sellerModel->id = $seller->id()->value();
        $sellerModel->name = $seller->name()->value();
        $sellerModel->avatar = $seller->avatar()->value();
        $sellerModel->alegra_id = $seller->alegraId()?->value();

        return $sellerModel;
    }

    private function transformToDomain(SellerModel $sellerModel): Seller
    {
        return Seller::fromPrimitives(
            $sellerModel->id,
            $sellerModel->name,
            $sellerModel->avatar,
            $sellerModel->countVotesOnActiveContest(),
            $sellerModel->alegra_id
        );
    }
}
