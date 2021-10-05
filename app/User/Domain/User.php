<?php

namespace App\User\Domain;

use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserId;
use App\User\Domain\ValueObjects\UserName;

final class User
{
    public function __construct(
        private UserId $id,
        private UserName $name,
        private UserEmail $email
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $email
    ) {
        return new static(
            UserId::fromValue($id),
            UserName::fromValue($name),
            UserEmail::fromValue($email)
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
}
