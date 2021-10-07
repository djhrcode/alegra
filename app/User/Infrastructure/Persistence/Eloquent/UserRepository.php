<?php

namespace App\User\Infrastructure\Persistence\Eloquent;

use App\User\Domain\User;
use App\User\Domain\UserAuthenticable;
use App\User\Domain\UserCredentials;
use App\User\Domain\UserRepository as UserRepositoryInterface;
use App\User\Domain\ValueObjects\UserBearerToken;
use App\User\Domain\ValueObjects\UserId;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private UserModel $model)
    {
    }

    private function toModel(User $user): UserModel
    {
        $userModel = $this->model->newInstance();
        $userModel->id = $user->id()->value();
        $userModel->name = $user->name()->value();
        $userModel->email = $user->email()->value();
        $userModel->password = 'password';

        return $userModel;
    }

    private function toDomain(UserModel $userModel): User
    {
        return User::fromPrimitives(
            $userModel->id,
            $userModel->name,
            $userModel->email
        );
    }

    public function find(UserId $id): ?User
    {
        $userFound = $this->model->find($id->value());

        if (is_null($userFound)) return null;

        return $this->toDomain($userFound);
    }

    public function create(User $user): void
    {
        $userModel = $this->toModel($user);

        DB::transaction(fn () => $userModel->save());
    }

    public function delete(UserId $id): void
    {
        $this->model->findOrFail($id->value())->delete();
    }

    public function register(UserAuthenticable $user): UserBearerToken
    {
        $userModel = $this->model->newInstance();

        $userModel->name = $user->name()->value();
        $userModel->email = $user->email()->value();
        $userModel->password = $user->password()->value();

        $userModel->saveOrFail();

        return UserBearerToken::fromValue(
            $userModel->createToken('auth_token')->plainTextToken
        );
    }

    public function login(UserCredentials $user): UserBearerToken
    {
        $userModel = $this->model
            ->newQuery()
            ->where(['email' => $user->email()->value()])
            ->firstOrFail();

        return UserBearerToken::fromValue(
            $userModel->createToken('auth_token')->plainTextToken
        );
    }
}
