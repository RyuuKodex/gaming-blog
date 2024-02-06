<?php

declare(strict_types=1);

namespace App\Tests\User\Infrastructure\AccountManager\Client\Response;

use App\User\Domain\Enum\IdentifierType;
use App\User\Infrastructure\AccountManager\Client\Response\IdentifierResponse;
use PHPUnit\Framework\TestCase;

final class TestIdentifier extends TestCase
{
    public function testCreate(): void
    {
        $identifier = new IdentifierResponse(IdentifierType::Id, 'id');

        $this->assertSame(IdentifierType::Id, $identifier->getType());
        $this->assertSame('id', $identifier->getValue());
    }
}
