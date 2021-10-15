<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use App\Seller\Domain\Seller;

final class SellerJsonDataFactory
{
    const DEFAULT_STATUS = 'active';
    const DEFAULT_OBSERVATIONS = 'Concurso "Vendedores a correr"';

    public function create(Seller $seller): array
    {
        return [
            'id' => $seller->id()->value(),
            'name' => $seller->name()->value(),
            'status' => static::DEFAULT_STATUS,
            'observations' => static::DEFAULT_OBSERVATIONS,
        ];
    }
}
