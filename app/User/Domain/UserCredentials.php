<?php

namespace App\User\Domain;

use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserId;
use App\User\Domain\ValueObjects\UserName;
use App\User\Domain\ValueObjects\UserPassword;

final class UserCredentials
{
    public function __construct(
        private UserEmail $email,
        private UserPassword $password
    ) {
    }

    public static function fromPrimitives(
        string $email,
        string $password
    ) {
        return new static(
            UserEmail::fromValue($email),
            UserPassword::fromValue($password)
        );
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }
}
