<?php

namespace App\Enums;

enum CategoryStatus: string
{
    case ONLINE = 'online' ;
    case DEACTIVATED = 'deactivated' ;
    case ARCHIVED = 'archived' ;
}
