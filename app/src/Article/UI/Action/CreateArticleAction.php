<?php

declare(strict_types=1);

namespace App\Article\UI\Action;

use App\Article\Application\Command\CreateArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CreateArticleAction extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus) {}

    #[Route('/api/create-article', methods: 'POST')]
    public function __invoke(Request $request): JsonResponse
    {
        $id = Uuid::v4();

        $data = json_decode($request->getContent(), true);

        $command = new CreateArticle($id, $data['author'], $data['title'], $data['text']);
        $this->messageBus->dispatch($command);

        return new JsonResponse('', Response::HTTP_CREATED);
    }
}
