<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\DeleteArticleCommand;
use App\Article\Application\Command\DeleteArticleHandler;
use App\Article\Domain\Repository\ArticleStoreInterface;
use App\Article\Infrastructure\Entity\Article;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class DeleteArticleHandlerTest extends TestCase
{
    public function testDelete(): void
    {
        $articleStoreMock = $this->createMock(ArticleStoreInterface::class);

        $article = $this->createMock(Article::class);
        $articleStoreMock
            ->expects(self::once())
            ->method('findOneByUuid')
            ->with(Uuid::fromString('0646a544-df08-417a-8a48-0ee369c94e8f'))
            ->willReturn($article)
        ;

        $articleStoreMock
            ->expects(self::once())
            ->method('delete')
            ->with($article)
        ;

        $handler = new DeleteArticleHandler($articleStoreMock);
        $command = new DeleteArticleCommand(Uuid::fromString('0646a544-df08-417a-8a48-0ee369c94e8f'));
        $handler($command);
    }
}
