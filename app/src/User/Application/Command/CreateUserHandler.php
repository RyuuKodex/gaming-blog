<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Entity\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserHandler
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function __invoke(CreateUser $command): void
    {
        $user = new User($command->getId(), $command->getName(), $command->getIdentifier(), $command->getToken());

        $this->userRepository->save($user);
    }
}
