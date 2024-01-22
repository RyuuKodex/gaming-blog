<?php

declare(strict_types=1);

namespace App\Article\UI\Form\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ArticleDto
{
    #[Assert\NotBlank]
    private string $title;
    #[Assert\NotBlank]
    private string $content;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
