<?php

namespace App\User\Domain;

use App\User\Domain\ValueObjects\UserBearerToken;
use App\User\Domain\ValueObjects\UserId;

interface UserRepository
{
   public function find(UserId $id): ?User;

    public function delete(UserId $id): void;

    public function create(User $user): void;

    public function register(UserAuthenticable $user): UserBearerToken;

    public function login(UserCredentials $user): UserBearerToken;
}
