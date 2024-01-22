<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use Symfony\Component\Uid\Uuid;

final readonly class CreateUser
{
    public function __construct(
        private Uuid $id,
        private string $name,
        private string $identifier,
        private string $token
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
