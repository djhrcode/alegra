<?php

namespace App\User\Application\Resources;

use App\Shared\Application\Resources\Resource;
use App\User\Domain\ValueObjects\UserBearerToken;

class BearerTokenResource extends Resource
{
    public function transform(UserBearerToken $bearer): array
    {
        return [
            'token_type' => 'Bearer',
            'access_token' => $bearer->value(),
        ];
    }
}
