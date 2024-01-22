<?php

declare(strict_types=1);

namespace App\Common\Security;

use App\User\Application\Command\CreateUser;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\AccountManager\Client\CheckLoggedUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Uid\Uuid;

final class AtCloudAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly CheckLoggedUser $checkLoggedUser,
        private readonly UserRepositoryInterface $userRepository,
        private readonly MessageBusInterface $messageBus,
    ) {}

    public function supports(Request $request): ?bool
    {
        if (null === $request->get('token')) {
            return false;
        }

        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->get('token');
        $userData = $this->checkLoggedUser->fetchUserInformation($token);
        $identifierValue = $userData->getIdentifier()->getValue();
        $user = $this->userRepository->findOneByIdentifier($identifierValue);

        if (null === $user) {
            $this->messageBus->dispatch(new CreateUser(Uuid::v4(), $userData->getName(), $identifierValue, $token));
        } else {
            $user->updateToken($token);
        }

        return new SelfValidatingPassport(new UserBadge($identifierValue));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
