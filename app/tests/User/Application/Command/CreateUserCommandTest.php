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
            Uuid::fromString('9529dc69-6d6e-439c-9c57-fbb36c299f65'),
            'name',
            'id',
            'someToken'
        );

        $this->assertEquals(Uuid::fromString('9529dc69-6d6e-439c-9c57-fbb36c299f65'), $command->id);
        $this->assertSame('name', $command->name);
        $this->assertSame('id', $command->identifier);
        $this->assertSame('someToken', $command->token);
    }
}
