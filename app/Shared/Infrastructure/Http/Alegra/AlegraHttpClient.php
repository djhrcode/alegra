<?php

namespace App\Shared\Infrastructure\Http\Alegra;

use App\Shared\Infrastructure\Http\Contracts\HttpClient;
use App\Shared\Infrastructure\Http\Traits\HttpClientMethods;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

final class AlegraHttpClient implements HttpClient
{
    use HttpClientMethods;

    private PendingRequest $client;

    public function __construct(Http $client)
    {
        $this->assertServiceConfigIsRight();

        $this->client = $client::withOptions([
            /**
             * Alegra REST API base url for all endpoints
             */
            'base_uri' => config('services.alegra.api_url'),

            /**
             * Authorization headers for Alegra REST API
             */
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . config('services.alegra.secret')
            ]
        ]);

        logger("Client created for Alegra", ['options' => [
            'base_uri' => config('services.alegra.api_url'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . config('services.alegra.secret')
            ]
        ], 'client' => $this->client]);
    }

    private function assertServiceConfigIsRight(): void
    {
        if (!is_string($api_url = config('services.alegra.api_url')))
            throw new InvalidArgumentException(
                "Alegra service [api_url] setting must be a string. Received {$api_url}"
            );

        if (!is_string($api_url = config('services.alegra.secret')))
            throw new InvalidArgumentException(
                "Alegra service [secret] setting must be a string. Received {$api_url}"
            );
    }
}
