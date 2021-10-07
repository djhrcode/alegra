<?php

namespace App\User\Application\Resources;

use App\Shared\Application\Resources\Resource;
use App\User\Domain\User;

class UserResource extends Resource
{
    public function transform(User $user): array
    {
        return [
            'id' => $user->id()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
        ];
    }
}
