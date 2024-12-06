<?php

namespace App\Enums;

use App\Models\Partner;

enum Status: string
{
    case DRAFT = 'draft';
    case HIDDEN = 'hidden';
    case PUBLISHED = 'published';
}
