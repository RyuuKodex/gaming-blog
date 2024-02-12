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
            Uuid::fromString('18438f6e-3b2d-404b-ac5e-42bf178d3e5b'),
            'title',
            'title',
            'content',
            $user,
            $createdAt
        );

        $this->assertEquals(Uuid::fromString('18438f6e-3b2d-404b-ac5e-42bf178d3e5b'), $article->getId());
        $this->assertSame('title', $article->getTitle());
        $this->assertSame('title', $article->getSlug());
        $this->assertSame('content', $article->getContent());
        $this->assertEquals($user, $article->getAuthor());
        $this->assertNull($article->getReviewer());
        $this->assertEquals($createdAt, $article->getCreatedAt());
        $this->assertNull($article->getUpdatedAt());
    }
}
