<?php

declare(strict_types=1);

namespace Domain\Enums;

enum Status: string
{
    case STARTED     = 'started';
    case IN_PROGRESS = 'inProgress';
    case PAUSED      = 'paused';
}
