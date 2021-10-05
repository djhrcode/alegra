<?php

namespace App\Shared\Infrastructure\Http\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

trait HttpClientMethods
{
    private function client(): PendingRequest
    {
        return $this->client;
    }

    public function get(string $url, array|null $query = null): Response
    {
        return $this->client()->get($url, $query);
    }

    public function post(string $url, array $data = []): Response
    {
        return $this->client()->post($url, $data);
    }

    public function put(string $url, array $data = []): Response
    {
        return $this->client()->put($url, $data);
    }

    public function delete(string $url, array $data = []): Response
    {
        return $this->client()->delete($url, $data);
    }
}
