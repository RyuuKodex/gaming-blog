<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserStoreInterface;
use App\User\Infrastructure\Entity\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserHandler
{
    public function __construct(private UserStoreInterface $userStore) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User($command->id, $command->name, $command->identifier, $command->token);

        $this->userStore->save($user);
    }
}
