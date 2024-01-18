<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Infrastructure\Entity\Article;
use App\Article\Infrastructure\Repository\ArticleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateArticleHandler
{
    public function __construct(private ArticleRepository $repository) {}

    public function __invoke(CreateArticle $command): void
    {
        $article = new Article(
            $command->getId(),
            $command->getAuthor(),
            $command->getTitle(),
            $command->getText(),
            new \DateTimeImmutable()
        );

        $this->repository->save($article);
    }
}
