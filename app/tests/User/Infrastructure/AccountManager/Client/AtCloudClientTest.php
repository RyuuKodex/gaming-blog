<?php

declare(strict_types=1);

namespace App\Tests\User\Infrastructure\AccountManager\Client;

use App\User\Infrastructure\AccountManager\Client\AtCloudClient;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class AtCloudClientTest extends TestCase
{
    public function testFetchUserInformation(): void
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $responseData = [
            'name' => 'John Doe',
            'identifier' => [
                'type' => 'id',
                'value' => 'id',
            ],
        ];

        $httpClient
            ->expects(self::once())
            ->method('request')
            ->with(
                'GET',
                'https://accounts.atcloud.pro/api/security/me',
                [
                    'headers' => [
                        'X-Sso-External-Service-Id' => ' c737542a-8d55-4d92-bdc6-0379694abc56',
                        'Authorization' => 'Bearer token',
                    ],
                ]
            )
            ->willReturn($response)
        ;

        $response
            ->expects(self::once())
            ->method('toArray')
            ->willReturn($responseData)
        ;

        $atCloudClient = new AtCloudClient($httpClient);
        $userDataResponse = $atCloudClient->fetchUserInformation('token');

        $this->assertSame($responseData['name'], $userDataResponse->getName());
        $this->assertSame($responseData['identifier']['type'], $userDataResponse->getIdentifier()->getType()->value);
        $this->assertSame($responseData['identifier']['value'], $userDataResponse->getIdentifier()->getValue());
    }
}
