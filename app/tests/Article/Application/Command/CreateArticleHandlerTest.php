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
                    $article->getId()->equals(Uuid::fromString('acd6780c-95a2-4c78-bd4b-d17ab5908c49'))
                    && 'title' === $article->getTitle()
                    && 'title' === $article->getSlug()
                    && 'content' === $article->getContent()
                    && $user === $article->getAuthor()
                )
            ))
        ;

        $handler = new CreateArticleHandler($articleStoreMock, $sluggerMock);
        $command = new CreateArticleCommand(
            Uuid::fromString('acd6780c-95a2-4c78-bd4b-d17ab5908c49'),
            'title',
            'content',
            $user
        );

        $handler($command);
    }
}
