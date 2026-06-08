<?php

namespace App\Enums;

enum ProductStatus : string
{
    case ONLINE = 'online';
    case DRAFT = 'draft';
    case ARCHIVED = 'archived';
}
