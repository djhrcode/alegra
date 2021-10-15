<?php

namespace Tests\Feature\Account;

use App\User\Infrastructure\Persistence\Eloquent\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowEndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauthenticated_account_endpoint_fails()
    {
        $response = $this->get('/api/v1/account');

        $response->assertStatus(401);
    }

    public function test_authenticated_account_endpoint_works_properly()
    {
        $user = UserModel::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/account');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
            ]
        ]);
    }
}
