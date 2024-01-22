<?php

declare(strict_types=1);

namespace App\User\Domain\Enum;

enum IdentifierType: string
{
    case Email = 'email';
    case Id = 'id';
}
