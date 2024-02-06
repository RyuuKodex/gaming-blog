<?php

declare(strict_types=1);

namespace App\Tests\Article\Infrastructure\Entity;

use App\Article\Infrastructure\Entity\Article;
use App\User\Infrastructure\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class ArticleTest extends TestCase
{
    public function testCreate(): void
    {
        $user = $this->createMock(User::class);
        $createdAt = $this->createMock(\DateTimeImmutable::class);
        $article = new Article(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'title',
            'title',
            'content',
            $user,
            $createdAt
        );

        $this->assertEquals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'), $article->getId());
        $this->assertSame('title', $article->getTitle());
        $this->assertSame('title', $article->getSlug());
        $this->assertSame('content', $article->getContent());
        $this->assertEquals($user, $article->getAuthor());
        $this->assertNull($article->getReviewer());
        $this->assertEquals($createdAt, $article->getCreatedAt());
        $this->assertNull($article->getUpdatedAt());
    }
}
