<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Repository\ArticleStoreInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteArticleHandler
{
    public function __construct(private ArticleStoreInterface $store) {}

    public function __invoke(DeleteArticleCommand $command): void
    {
        $article = $this->store->findOneByUuid($command->id);

        $this->store->delete($article);
    }
}
