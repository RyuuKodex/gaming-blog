<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use Symfony\Component\Uid\Uuid;

final readonly class CreateArticle
{
    public function __construct(
        private Uuid $id,
        private string $author,
        private string $title,
        private string $text,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
