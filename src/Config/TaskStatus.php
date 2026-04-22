<?php

namespace App\Config;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}