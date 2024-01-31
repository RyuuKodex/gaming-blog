<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Repository\ArticleStoreInterface;
use App\Article\Infrastructure\Entity\Article;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsMessageHandler]
final readonly class CreateArticleHandler
{
    public function __construct(private ArticleStoreInterface $articleStore, private SluggerInterface $slugger) {}

    public function __invoke(CreateArticleCommand $command): void
    {
        $slug = $this->slugger->slug($command->getTitle());

        $article = new Article(
            $command->getId(),
            $command->getTitle(),
            strtolower($slug->toString()),
            $command->getContent(),
            $command->getAuthor(),
            new \DateTimeImmutable()
        );

        $this->articleStore->save($article);
    }
}
