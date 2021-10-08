<?php

namespace App\Vote\Domain\Events;

use App\Vote\Domain\Vote;

interface VoteTransactionEvent
{
    public function vote(): Vote;
}
