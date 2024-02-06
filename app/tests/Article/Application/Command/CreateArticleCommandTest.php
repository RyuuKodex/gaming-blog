<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\CreateArticleCommand;
use App\User\Infrastructure\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class CreateArticleCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $user = $this->createMock(User::class);

        $command = new CreateArticleCommand(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'title',
            'content',
            $user
        );

        $this->assertEquals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'), $command->getId());
        $this->assertSame('title', $command->getTitle());
        $this->assertSame('content', $command->getContent());
        $this->assertSame($user, $command->getAuthor());
    }
}
