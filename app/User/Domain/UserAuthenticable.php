<?php

namespace App\User\Domain;

use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserId;
use App\User\Domain\ValueObjects\UserName;
use App\User\Domain\ValueObjects\UserPassword;

final class UserAuthenticable
{
    public function __construct(
        private UserId $id,
        private UserName $name,
        private UserEmail $email,
        private UserPassword $password
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $email,
        string $password
    ) {
        return new static(
            UserId::fromValue($id),
            UserName::fromValue($name),
            UserEmail::fromValue($email),
            UserPassword::fromValue($password)
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return UserPassword::fromValue(bcrypt($this->password->value()));
    }
}
