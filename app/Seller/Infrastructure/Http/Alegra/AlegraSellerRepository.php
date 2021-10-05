<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use App\Shared\Infrastructure\Http\Alegra\AlegraHttpClient;
use Exception;

class AlegraSellerRepository
{
    public function __construct(private AlegraHttpClient $client)
    {
    }

    public function find(int $sellerId): ?AlegraSeller
    {
        $response = $this->client->get("sellers/{$sellerId}");

        $response->throw();

        return AlegraSeller::fromArray($response->json()[0]);
    }

    public function create(AlegraSeller $user): AlegraSeller
    {
        $response = $this->client->post("sellers", $user->toArray());

        logger("Request response to /api/v1/sellers", ['response' => $response]);

        $response->throw();

        return AlegraSeller::fromArray($response->json());
    }

    public function delete(int $sellerId): void
    {
        $this->client->delete("sellers/{$sellerId}")->throw();
    }
}
