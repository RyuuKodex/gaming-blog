<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client;

use App\User\Domain\Enum\IdentifierType;
use App\User\Infrastructure\AccountManager\Client\Response\Identifier;
use App\User\Infrastructure\AccountManager\Client\Response\UserDataResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class CheckLoggedUser
{
    public function __construct(private HttpClientInterface $client) {}

    public function fetchUserInformation(string $token): UserDataResponse
    {
        $response = $this->client->request(
            'GET',
            'https://accounts.atcloud.pro/api/security/me',
            ['headers' => [
                'X-Sso-External-Service-Id' => ' c737542a-8d55-4d92-bdc6-0379694abc56 ',
                'Authorization' => "Bearer {$token}",
            ],
            ]
        );

        $data = $response->toArray();

        return new UserDataResponse($data['name'], new Identifier(IdentifierType::from($data['identifier']['type']), $data['identifier']['value']));
    }
}
