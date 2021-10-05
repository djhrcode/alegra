<?php

namespace App\User\Infrastructure\Persistence\Eloquent;

use App\User\Domain\User;
use App\User\Domain\UserRepository as UserRepositoryInterface;
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
}
