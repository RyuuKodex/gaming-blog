<?php

declare(strict_types=1);

namespace App\Tests\User\Infrastructure\Entity;

use App\User\Infrastructure\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new User(
            Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'),
            'John Doe',
            'id',
            'token'
        );

        $this->assertEquals(Uuid::fromString('74428275-0df2-4cf6-be7c-c55ee6e50c20'), $user->getId());
        $this->assertSame('John Doe', $user->getName());
        $this->assertSame('id', $user->getUserIdentifier());
        $this->assertSame('token', $user->getToken());
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertEquals(new ArrayCollection(), $user->getArticles());
        $this->assertEquals(new ArrayCollection(), $user->getReviewedArticles());
    }
}
