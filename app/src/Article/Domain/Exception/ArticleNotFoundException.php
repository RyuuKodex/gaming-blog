<?php

declare(strict_types=1);

namespace App\Article\Domain\Exception;

class ArticleNotFoundException extends \RuntimeException
{
    public static function articleNotFound(): self
    {
        return new self('Article not found');
    }
}
