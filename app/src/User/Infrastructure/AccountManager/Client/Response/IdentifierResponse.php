<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client\Response;

use App\User\Domain\Enum\IdentifierType;

final readonly class IdentifierResponse implements IdentifierResponseInterface
{
    public function __construct(private IdentifierType $type, private string $value) {}

    public function getType(): IdentifierType
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
