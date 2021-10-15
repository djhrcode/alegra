<?php

namespace Tests\Feature\Sellers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImagesSearchEndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fails_if_not_query_param()
    {
        $response = $this->get('/api/v1/sellers/images');

        $response->assertStatus(422);
    }

    public function test_not_fails_when_query_is_present()
    {
        $response = $this->get('/api/v1/sellers/images?query=coffee');

        $response->assertStatus(200);
    }

    public function test_json_structure_is_right()
    {
        $response = $this->json('GET', '/api/v1/sellers/images?query=coffee');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'width',
                    'height',
                    'color',
                    'urls' => [
                        'full',
                        'regular',
                        'small',
                        'thumb',
                    ],
                    'seller' => [
                        'id',
                        'avatar',
                        'name',
                        'total_points',
                        'remaining_points',
                    ],
                    'links' => [
                        'seller',
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
        $response = $this->json('GET', '/api/v1/sellers?query=coffee&page=2');

        $response->assertJsonPath('meta.pagination.current_page', 2);
    }
}
