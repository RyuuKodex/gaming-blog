<?php

declare(strict_types=1);

namespace App\Tests\User\Application\Command;

use App\User\Application\Command\CreateUserCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class CreateUserCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $command = new CreateUserCommand(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'name',
            'id',
            'someToken'
        );

        $this->assertEquals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'), $command->getId());
        $this->assertSame('name', $command->getName());
        $this->assertSame('id', $command->getIdentifier());
        $this->assertSame('someToken', $command->getToken());
    }
}
