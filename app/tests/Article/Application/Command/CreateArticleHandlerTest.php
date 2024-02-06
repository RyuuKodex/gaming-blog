<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Application\Command\CreateArticleHandler;
use App\Article\Domain\Repository\ArticleStoreInterface;
use App\Article\Infrastructure\Entity\Article;
use App\User\Infrastructure\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\Uid\Uuid;

final class CreateArticleHandlerTest extends TestCase
{
    public function testCreateArticle(): void
    {
        $articleStoreMock = $this->createMock(ArticleStoreInterface::class);
        $sluggerMock = $this->createMock(SluggerInterface::class);
        $user = $this->createMock(User::class);

        $sluggerMock
            ->expects(self::once())
            ->method('slug')
            ->willReturn(new UnicodeString('title'))
        ;

        $articleStoreMock
            ->expects(self::once())
            ->method('save')
            ->with(self::callback(
                fn (Article $article) => (
                    $article->getId()->equals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'))
                    && 'title' === $article->getTitle()
                    && 'title' === $article->getSlug()
                    && 'content' === $article->getContent()
                    && $user === $article->getAuthor()
                )
            ))
        ;

        $handler = new CreateArticleHandler($articleStoreMock, $sluggerMock);
        $command = new CreateArticleCommand(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'title',
            'content',
            $user
        );

        $handler($command);
    }
}
