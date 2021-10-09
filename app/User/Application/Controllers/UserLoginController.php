<?php

namespace App\User\Application\Controllers;

use App\User\Application\Resources\BearerTokenResource;
use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use App\User\Application\Requests\UserLoginRequest;
use App\User\Domain\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class UserLoginController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private SerializerManager $manager,
        private BearerTokenResource $resource,
        private Auth $authentication
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
        $credentialsAreValid = $this->authentication::validate([
            'email' => $request->value()->email()->value(),
            'password' => $request->value()->password()->value()
        ]);

        if (!$credentialsAreValid)
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['La contraseña ingresada es incorrecta'],
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        $bearerToken = $this->users->login($request->value());

        return $this->manager->serialize(
            $this->resource->makeItem($bearerToken)
        );
    }
}
