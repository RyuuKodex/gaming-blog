<?php

declare(strict_types=1);

namespace App\Tests\User\Application\Command;

use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Command\CreateUserHandler;
use App\User\Domain\Repository\UserStoreInterface;
use App\User\Infrastructure\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class CreateUserHandlerTest extends TestCase
{
    public function testHandler(): void
    {
        $userStore = $this->createMock(UserStoreInterface::class);

        $userStore
            ->expects(self::once())
            ->method('save')
            ->with(self::callback(
                fn (User $user) => (
                    $user->getId()->equals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'))
                && 'name' === $user->getName()
                && 'id' === $user->getUserIdentifier()
                && 'someToken' === $user->getToken()
                )
            ))
        ;

        $handler = new CreateUserHandler($userStore);
        $command = new CreateUserCommand(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'name',
            'id',
            'someToken'
        );

        $handler($command);
    }
}
