<?php

namespace App\Seller\Application\Listeners;

use App\Seller\Application\Events\SellerHasBeenCreated;
use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerRepository;
use App\Seller\Infrastructure\Http\Alegra\AlegraSeller;
use App\Seller\Infrastructure\Http\Alegra\AlegraSellerRepository;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;

class SyncCreatedSellerWithAlegra
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private SellerRepository $sellers,
        private AlegraSellerRepository $alegraSellers
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SellerHasBeenCreated $event)
    {
        $seller = $event->seller();

        if (!is_null($seller->alegraId()?->value())) return;

        $alegraSeller = $this->alegraSellers->create(
            AlegraSeller::new(
                $seller->id()->value(),
                $seller->name()->value()
            )
        );

        print("Syncing seller {$seller->id()->value()} with Alegra \n");

        $this->sellers->update(
            $seller->id(),
            Seller::fromPrimitives(
                $seller->id()->value(),
                $seller->name()->value(),
                $seller->avatar()->value(),
                $seller->points()->value(),
                $alegraSeller->id()
            )
        );
    }
}
