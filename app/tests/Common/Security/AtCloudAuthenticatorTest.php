<?php

declare(strict_types=1);

namespace App\Tests\Common\Security;

use App\Common\Security\AtCloudAuthenticator;
use App\User\Domain\Repository\UserStoreInterface;
use App\User\Infrastructure\AccountManager\Client\AtCloudClient;
use App\User\Infrastructure\AccountManager\Client\AtCloudClientInterface;
use App\User\Infrastructure\AccountManager\Client\Response\IdentifierResponseInterface;
use App\User\Infrastructure\AccountManager\Client\Response\UserDataResponseInterface;
use App\User\Infrastructure\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class AtCloudAuthenticatorTest extends TestCase
{
    public function testSupports(): void
    {
        $atCloudClient = new AtCloudClient($this->createMock(HttpClientInterface::class));
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);

        $request
            ->expects(self::once())
            ->method('get')
            ->willReturn('token')
        ;

        $this->assertTrue($atCloudAuthenticator->supports($request));
    }

    public function testDoesNotSupport(): void
    {
        $atCloudClient = new AtCloudClient($this->createMock(HttpClientInterface::class));
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);

        $request
            ->expects(self::once())
            ->method('get')
            ->willReturn(null)
        ;

        $this->assertFalse($atCloudAuthenticator->supports($request));
    }

    public function testAuthenticateIfUserWasFound(): void
    {
        $atCloudClient = $this->createMock(AtCloudClientInterface::class);
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);
        $request
            ->expects(self::once())
            ->method('get')
            ->willReturn('token')
        ;

        $userDataResponse = $this->createMock(UserDataResponseInterface::class);

        $atCloudClient
            ->expects(self::once())
            ->method('fetchUserInformation')
            ->with('token')
            ->willReturn($userDataResponse)
        ;

        $identifierResponse = $this->createMock(IdentifierResponseInterface::class);

        $userDataResponse
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn($identifierResponse)
        ;

        $identifierResponse
            ->expects(self::once())
            ->method('getValue')
            ->willReturn('id')
        ;

        $user = $this->createMock(User::class);

        $userStore
            ->expects(self::once())
            ->method('findOneByIdentifier')
            ->with('id')
            ->willReturn($user)
        ;

        $user
            ->expects(self::once())
            ->method('updateToken')
        ;

        $passport = $atCloudAuthenticator->authenticate($request);

        $this->assertInstanceOf(SelfValidatingPassport::class, $passport);
    }

    public function testAuthenticateIfUserWasNotFound(): void
    {
        $atCloudClient = $this->createMock(AtCloudClientInterface::class);
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);
        $request
            ->expects(self::once())
            ->method('get')
            ->with('token')
            ->willReturn('token')
        ;

        $userDataResponse = $this->createMock(UserDataResponseInterface::class);

        $atCloudClient
            ->expects(self::once())
            ->method('fetchUserInformation')
            ->with('token')
            ->willReturn($userDataResponse)
        ;

        $identifierResponse = $this->createMock(IdentifierResponseInterface::class);

        $userDataResponse
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn($identifierResponse)
        ;

        $identifierResponse
            ->expects(self::once())
            ->method('getValue')
            ->willReturn('id')
        ;

        $userStore
            ->expects(self::once())
            ->method('findOneByIdentifier')
            ->with('id')
            ->willReturn(null)
        ;

        $messageBus
            ->expects(self::once())
            ->method('dispatch')
            ->willReturn(new Envelope($this->createMock(\stdClass::class)))
        ;

        $passport = $atCloudAuthenticator->authenticate($request);

        $this->assertInstanceOf(SelfValidatingPassport::class, $passport);
    }

    public function testOnAuthenticationSuccess(): void
    {
        $atCloudClient = new AtCloudClient($this->createMock(HttpClientInterface::class));
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);
        $token = $this->createMock(TokenInterface::class);

        $this->assertNull($atCloudAuthenticator->onAuthenticationSuccess($request, $token, ''));
    }

    public function testOnAuthenticationFailure(): void
    {
        $atCloudClient = new AtCloudClient($this->createMock(HttpClientInterface::class));
        $userStore = $this->createMock(UserStoreInterface::class);
        $messageBus = $this->createMock(MessageBusInterface::class);

        $atCloudAuthenticator = new AtCloudAuthenticator($atCloudClient, $userStore, $messageBus);

        $request = $this->createMock(Request::class);
        $exception = $this->createMock(AuthenticationException::class);

        $exception
            ->expects(self::once())
            ->method('getMessageKey')
            ->willReturn('messageKey')
        ;

        $exception
            ->expects(self::once())
            ->method('getMessageData')
            ->willReturn(['messageData'])
        ;

        $response = $atCloudAuthenticator->onAuthenticationFailure($request, $exception);

        $this->assertNotNull($response);
        $this->assertSame('{"message":"messageKey"}', $response->getContent());
    }
}
