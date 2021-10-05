<?php

namespace App\Shared\Infrastructure\Http\Unsplash;

use App\Shared\Infrastructure\Http\Contracts\HttpClient;
use App\Shared\Infrastructure\Http\Traits\HttpClientMethods;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

final class UnsplashHttpClient implements HttpClient
{
    use HttpClientMethods;

    private PendingRequest $client;

    public function __construct(Http $client)
    {
        $this->assertServiceConfigIsRight();

        $this->client = $client::withOptions([
            /**
             * Unsplash REST API base url for all endpoints
             */
            'base_uri' => config('services.unsplash.api_url'),

            /**
             * Authorization headers for Unsplash REST API
             */
            'headers' => [
                'Authorization' => 'Client-ID ' . config('services.unsplash.secret')
            ]
        ]);
    }

    private function assertServiceConfigIsRight(): void
    {
        if (!is_string($api_url = config('services.unsplash.api_url')))
            throw new InvalidArgumentException(
                "Unsplash API service [api_url] setting must be a string. Received {$api_url}"
            );

            if (!is_string($api_url = config('services.unsplash.secret')))
            throw new InvalidArgumentException(
                "Unsplash API service [secret] setting must be a string. Received {$api_url}"
            );
    }
}
