<?php

namespace App\Vote\Domain\Events;

use App\Vote\Domain\Vote;

interface VoteEvent
{
    public function vote(): Vote;
}
