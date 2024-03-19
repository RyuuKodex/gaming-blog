<?php

declare(strict_types=1);

namespace App\Article\UI\Action;

use App\Article\Application\Command\DeleteArticleCommand;
use App\Article\Infrastructure\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeleteArticleAction extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus) {}

    #[Route('/app/article/delete/{article}')]
    public function __invoke(Request $request, Article $article): Response
    {
        $command = new DeleteArticleCommand($article->getId());

        $this->messageBus->dispatch($command);

        return $this->redirectToRoute('home.html.twig');
    }
}
