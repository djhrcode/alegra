<?php

namespace App\User\Domain;

use App\User\Domain\ValueObjects\UserId;

interface UserRepository
{
   public function find(UserId $id): ?User;

    public function delete(UserId $id): void;

    public function create(User $user): void;
}
