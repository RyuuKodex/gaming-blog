<?php

declare(strict_types=1);

namespace App\Article\UI\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateArticleData
{
    #[Assert\NotBlank]
    public string $title;

    #[Assert\NotBlank]
    public string $content;
}
