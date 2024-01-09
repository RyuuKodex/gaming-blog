<?php

declare(strict_types=1);

namespace App\Tests\functional\helper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class HttpClientAwareTestCase extends TestCase
{
    protected HttpClientInterface $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = HttpClient::create([
            'base_uri' => 'http://localhost',
        ]);
    }
}
