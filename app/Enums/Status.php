<?php

namespace App\Enums;

enum Status: string
{
    case DRAFT = 'draft';
    case HIDDEN = 'hidden';
    case PUBLISHED = 'published';
}
