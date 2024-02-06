<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client\Response;

use App\User\Domain\Enum\IdentifierType;

interface IdentifierResponseInterface
{
    public function getType(): IdentifierType;

    public function getValue(): string;
}
