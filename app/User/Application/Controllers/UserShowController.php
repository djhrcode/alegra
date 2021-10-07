<?php

namespace App\User\Application\Controllers;

use App\Shared\Application\Http\Controllers\Controller;
use App\Shared\Application\Resources\SerializerManager;
use App\User\Application\Resources\UserResource;
use App\User\Domain\User;
use Illuminate\Http\Request;

class UserShowController extends Controller
{
    public function __construct(
        private SerializerManager $manager,
        private UserResource $resource
    ) {
        $this->middleware('auth:sanctum');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::fromPrimitives(
            $request->user()->id,
            $request->user()->name,
            $request->user()->email,
        );

        return $this->manager->serialize($this->resource->makeItem($user));
    }
}
