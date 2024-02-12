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
            Uuid::fromString('6315c9bf-7366-43ef-88dd-aab6543a04ff'),
            'John Doe',
            'id',
            'token'
        );

        $this->assertEquals(Uuid::fromString('6315c9bf-7366-43ef-88dd-aab6543a04ff'), $user->getId());
        $this->assertSame('John Doe', $user->getName());
        $this->assertSame('id', $user->getUserIdentifier());
        $this->assertSame('token', $user->getToken());
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertEquals(new ArrayCollection(), $user->getArticles());
        $this->assertEquals(new ArrayCollection(), $user->getReviewedArticles());
    }
}
