<?php

namespace App\Enums;

enum FeedStatus
{

    case SYNCED;

    case COMPLETED;

    public function getStatus(): string
    {
        return match($this)
        {
            self::SYNCED => 'synchronizing',
            self::COMPLETED => 'completed',
        };
    }

}
