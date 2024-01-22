<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client\Response;

final readonly class UserDataResponse
{
    public function __construct(private string $name, private Identifier $identifier) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }
}
