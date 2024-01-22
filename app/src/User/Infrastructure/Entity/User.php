<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entity;

use App\User\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;
    #[ORM\Column]
    private string $name;
    #[ORM\Column]
    private string $identifier;
    #[ORM\Column(type: 'text')]
    private string $token;

    /** @var string[] */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct(Uuid $id, string $name, string $identifier, string $token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->identifier = $identifier;
        $this->token = $token;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function updateToken(string $token): void
    {
        $this->token = $token;
    }

    /** @return string[] */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void {}
}
