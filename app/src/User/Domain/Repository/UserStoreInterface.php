<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Infrastructure\Entity\User;

interface UserStoreInterface
{
    public function save(User $entity): void;

    public function findOneByIdentifier(string $identifier): ?User;
}
