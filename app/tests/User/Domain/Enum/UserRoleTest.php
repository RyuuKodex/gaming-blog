<?php

declare(strict_types=1);

namespace App\Tests\User\Domain\Enum;

use App\User\Domain\Enum\UserRole;
use PHPUnit\Framework\TestCase;

final class UserRoleTest extends TestCase
{
    public function testEnum(): void
    {
        $this->assertCount(3, UserRole::cases());
        $this->assertSame('ROLE_USER', UserRole::User->value);
        $this->assertSame('ROLE_AUTHOR', UserRole::Author->value);
        $this->assertSame('ROLE_REVIEWER', UserRole::Reviewer->value);
    }
}
