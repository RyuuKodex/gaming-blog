<?php

declare(strict_types=1);

namespace App\Tests\Article\UI\Form\Data;

use App\Article\UI\Form\Data\CreateArticleData;
use PHPUnit\Framework\TestCase;

final class CreateArticleDataTest extends TestCase
{
    public function testCreate(): void
    {
        $data = new CreateArticleData();
        $data->setTitle('title');
        $data->setContent('content');

        $this->assertSame('title', $data->getTitle());
        $this->assertSame('content', $data->getContent());
    }
}
