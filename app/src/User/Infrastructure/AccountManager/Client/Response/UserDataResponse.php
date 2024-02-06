<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client\Response;

final readonly class UserDataResponse implements UserDataResponseInterface
{
    public function __construct(private string $name, private IdentifierResponse $identifier) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentifier(): IdentifierResponse
    {
        return $this->identifier;
    }
}
