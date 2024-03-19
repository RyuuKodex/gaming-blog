<?php

declare(strict_types=1);

namespace App\Article\Domain\Repository;

use App\Article\Infrastructure\Entity\Article;
use Symfony\Component\Uid\Uuid;

interface ArticleStoreInterface
{
    public function save(Article $entity): void;

    public function delete(Article $article): void;

    public function findOneByUuid(Uuid $id): Article;
}
