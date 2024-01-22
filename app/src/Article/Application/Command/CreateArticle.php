<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\User\Infrastructure\Entity\User;
use Symfony\Component\Uid\Uuid;

final readonly class CreateArticle
{
    public function __construct(
        private Uuid $id,
        private string $title,
        private string $content,
        private User $author
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
