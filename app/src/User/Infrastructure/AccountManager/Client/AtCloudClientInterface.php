<?php

declare(strict_types=1);

namespace App\User\Infrastructure\AccountManager\Client;

use App\User\Infrastructure\AccountManager\Client\Response\UserDataResponseInterface;

interface AtCloudClientInterface
{
    public function fetchUserInformation(string $token): UserDataResponseInterface;
}
