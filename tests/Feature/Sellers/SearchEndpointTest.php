<?php

namespace Tests\Feature\Sellers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchEndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_request_does_not_fail()
    {
        $response = $this->get('/api/v1/sellers');

        $response->assertStatus(200);
    }

    public function test_json_structure_is_right()
    {
        $response = $this->json('GET', '/api/v1/sellers');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'avatar',
                    'name',
                    'total_points',
                    'remaining_points',
                    'links' => [
                        'self',
                        'upvote'
                    ]
                ]
            ],
            'meta' => [
                'pagination' => [
                    'total',
                    'count',
                    'current_page',
                    'per_page',
                    'total_pages'
                ]
            ]
        ]);

        $response->assertJsonPath('meta.pagination.current_page', 1);
    }

    public function test_page_query_param_works_right()
    {
        $response = $this->json('GET', '/api/v1/sellers?page=2');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'avatar',
                    'name',
                    'total_points',
                    'remaining_points',
                    'links' => [
                        'self',
                        'upvote'
                    ]
                ]
            ],
            'meta' => [
                'pagination' => [
                    'total',
                    'count',
                    'current_page',
                    'per_page',
                    'total_pages'
                ]
            ]
        ]);

        $response->assertJsonPath('meta.pagination.current_page', 2);
    }
}
