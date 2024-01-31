<?php

declare(strict_types=1);

namespace App\Article\Domain\Repository;

use App\Article\Infrastructure\Entity\Article;

interface ArticleStoreInterface
{
    public function save(Article $entity): void;
}
