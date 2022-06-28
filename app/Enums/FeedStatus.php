<?php

namespace App\Enums;

enum FeedStatus
{
    case STOPPED;

    case SYNCING;

    case COMPLETED;


    public function getStatus(): string
    {
        return match ($this) {
            self::STOPPED => 'stopped',
            self::SYNCING => 'synchronizing',
            self::COMPLETED => 'completed',
        };
    }
}
