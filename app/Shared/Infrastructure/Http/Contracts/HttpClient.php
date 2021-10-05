<?php

namespace App\Shared\Infrastructure\Http\Contracts;

use Illuminate\Http\Client\Response;

interface HttpClient
{
    public function get(string $url, array|null $query = null): Response;

    public function post(string $url, array $data = []): Response;

    public function put(string $url, array $data = []): Response;

    public function delete(string $url, array $data = []): Response;
}
