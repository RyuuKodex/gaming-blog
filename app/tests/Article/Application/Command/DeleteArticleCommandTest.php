<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\DeleteArticleCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class DeleteArticleCommandTest extends TestCase
{
    public function testCreate(): void
    {
        $command = new DeleteArticleCommand(Uuid::fromString('79f01586-6197-4afe-a04d-4d550bb0d79f'));

        $this->assertEquals(Uuid::fromString('79f01586-6197-4afe-a04d-4d550bb0d79f'), $command->id);
    }
}
