<?php

namespace App\Seller\Application\Events;

use App\Seller\Domain\Seller;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use App\Seller\Infrastructure\Persistence\Eloquent\Traits\SellerTransformMethods;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SellerHasBeenCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    use SellerTransformMethods;

    private Seller $seller;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SellerModel $seller)
    {
        $this->seller = $this->transformToDomain($seller);
    }

    public function seller(): Seller
    {
        return $this->seller;
    }
}
