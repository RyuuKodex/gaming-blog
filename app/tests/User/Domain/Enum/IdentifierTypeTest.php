<?php

declare(strict_types=1);

namespace App\Tests\User\Domain\Enum;

use App\User\Domain\Enum\IdentifierType;
use PHPUnit\Framework\TestCase;

final class IdentifierTypeTest extends TestCase
{
    public function testEnum(): void
    {
        $this->assertCount(2, IdentifierType::cases());
        $this->assertSame('id', IdentifierType::Id->value);
        $this->assertSame('email', IdentifierType::Email->value);
    }
}
