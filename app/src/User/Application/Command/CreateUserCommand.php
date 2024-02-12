<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use Symfony\Component\Uid\Uuid;

final readonly class CreateUserCommand
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $identifier,
        public string $token
    ) {}
}
