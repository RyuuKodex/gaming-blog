<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Entity;

use App\Article\Infrastructure\Repository\ArticleRepository;
use App\User\Infrastructure\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;
    #[ORM\Column]
    private string $title;
    #[ORM\Column]
    private string $slug;
    #[ORM\Column(type: 'text')]
    private string $content;
    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'author_id', nullable: false)]
    private User $author;
    #[ORM\ManyToOne(inversedBy: 'reviewed_articles')]
    #[ORM\JoinColumn(name: 'reviewer_id', nullable: true)]
    private ?User $reviewer;
    #[ORM\Column]
    private \DateTimeImmutable $createdAt;
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

    public function __construct(
        Uuid $id,
        string $title,
        string $slug,
        string $text,
        User $author,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $text;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->updatedAt = null;
        $this->reviewer = null;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
