<?php

namespace App\Vote\Application\Events;

use App\Vote\Domain\Events\VoteTransactionEvent;
use App\Vote\Domain\Vote;
use App\Vote\Infrastructure\Persistence\Eloquent\Traits\VoteTransformMethods;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteHasBeenCreated implements VoteTransactionEvent
{
    use VoteTransformMethods;
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(private VoteModel $voteModel)
    {
    }

    public function vote(): Vote
    {
        return $this->transformToDomain($this->voteModel);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
