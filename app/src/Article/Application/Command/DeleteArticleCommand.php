<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use Symfony\Component\Uid\Uuid;

final readonly class DeleteArticleCommand
{
    public function __construct(public Uuid $id) {}
}
