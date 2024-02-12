<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\User\Infrastructure\Entity\User;
use Symfony\Component\Uid\Uuid;

final readonly class CreateArticleCommand
{
    public function __construct(
        public Uuid $id,
        public string $title,
        public string $content,
        public User $author
    ) {}
}
