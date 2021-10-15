<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerCollection;
use App\Seller\Domain\SellerRepository as SellerRepositoryInterface;
use App\Seller\Domain\SellerSearchCriteria;
use App\Seller\Domain\ValueObjects\SellerId;
use App\Shared\Domain\PaginationContext;
use App\Shared\Infrastructure\Http\Alegra\AlegraHttpClient;
use App\User\Domain\ValueObjects\UserId;
use Exception;

/**
 *
 * Creates a repository for creating, retrieving
 * and modifying Alegra API's Seller resource
 *
 * For more information please see the link below:
 * https://developer.alegra.com/docs/vendedores
 *
 */
class SellerRepository implements SellerRepositoryInterface
{
    public function __construct(
        private AlegraHttpClient $client,
        private SellerFactory $sellerFactory,
        private SellerJsonDataFactory $sellerJsonFactory,
        private SellerCollectionFactory $sellerCollectionFactory,
    ) {
    }


    /**
     * Makes a HTTP GET query to find a Seller by their id
     *
     * @param SellerId $id - The Alegra assigned Seller's ID
     * @return Seller|null
     *
     * For more information please see the link below
     * https://developer.alegra.com/docs/consultar-un-vendedor
     */
    public function find(SellerId $id): ?Seller
    {
        $response = $this->client->get("sellers/{$id->value()}");
        $response->throw();

        return $this->sellerFactory->create($response->json()[0]);
    }

    /**
     * Makes a HTTP POST request to create a Seller
     *
     * @param Seller $seller - The Seller that will be created
     * @return Seller
     *
     * For more information please see the link below
     * https://developer.alegra.com/docs/crear-vendedor
     */
    public function create(Seller $seller): Seller
    {
        $sellerJson = $this->sellerJsonFactory->create($seller);

        $response = $this->client->post("sellers", $sellerJson);

        logger("Request response to /api/v1/sellers", ['response' => $response]);

        $response->throw();

        return $this->sellerFactory->create($response->json());
    }

    /**
     * Makes a HTTP PUT request to update a Seller
     *
     * @param Seller $seller - The Seller that will be created
     * @return Seller
     *
     * For more information please see the link below
     * https://developer.alegra.com/docs/editar-vendedor
     */
    public function update(SellerId $sellerId, Seller $seller): void
    {
        $sellerJson = $this->sellerJsonFactory->create($seller);
        $response = $this->client->put("sellers/{$seller->alegraId()}", $sellerJson);

        logger("Request response to /api/v1/sellers", ['response' => $response]);

        $response->throw();
    }

    /**
     * Makes a HTTP GET request to find a Seller
     * and throws an exception if not found
     *
     * @return Seller
     */
    public function upvote(
        UserId $upvoterId,
        SellerId $sellerId,
        ContestId $contestId
    ): Seller {
        return throw_unless(
            $this->find($sellerId),
            'NotFoundException',
            'The seller you\'re trying to find does not exists'
        );
    }

    /**
     * Makes a HTTP GET request to retrieve a list of Sellers
     * and applies a pagination from the given criteria
     *
     * @return SellerCollection
     *
     * For more information please see the link below
     * https://developer.alegra.com/docs/lista-de-vendedores
     */
    public function search(SellerSearchCriteria $criteria): SellerCollection
    {
        $response = $this->client->get("sellers");
        $response->throw();

        $sellers = collect($response->json());
        $sellersCount = $sellers->count();
        $sellersLastPage = $sellersCount / $criteria->perPage();

        $pagination = new PaginationContext(
            $criteria->perPage(),
            $sellersCount,
            $sellersLastPage,
            $criteria->page(),
        );

        $sellers = $sellers->forPage(
            $pagination->getCurrentPage(),
            $pagination->getPerPage()
        )->all();

        return $this->sellerCollectionFactory->create($sellers, $pagination);
    }


    /**
     * Makes a HTTP DELETE request to remove a Seller
     *
     * @return SellerCollection
     *
     * For more information please see the link below
     * https://developer.alegra.com/docs/eliminar-vendedor
     */
    public function delete(SellerId $id): void
    {
        $this->client->delete("sellers/{$id->value()}")->throw();
    }
}
