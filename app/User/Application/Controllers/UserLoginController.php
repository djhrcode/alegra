<?php

namespace App\User\Application\Controllers;

use App\User\Application\Resources\BearerTokenResource;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use App\User\Application\Requests\UserLoginRequest;
use App\User\Domain\UserRepository;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private SerializerManager $manager,
        private BearerTokenResource $resource
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserLoginRequest $request)
    {
        $bearerToken = $this->users->login($request->value());

        return $this->manager->serialize(
            $this->resource->makeItem($bearerToken)
        );
    }
}
