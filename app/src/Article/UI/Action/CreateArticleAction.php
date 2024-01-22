<?php

declare(strict_types=1);

namespace App\Article\UI\Action;

use App\Article\Application\Command\CreateArticle;
use App\Article\UI\Form\Dto\ArticleDto;
use App\Article\UI\Form\Type\ArticleType;
use App\User\Infrastructure\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CreateArticleAction extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus) {}

    #[Route('/api/create-article')]
    public function __invoke(Request $request): Response
    {
        $articleDto = new ArticleDto();

        $form = $this->createForm(ArticleType::class, $articleDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ArticleDto $articleDto */
            $articleDto = $form->getData();
            $id = Uuid::v4();

            /** @var User $user */
            $user = $this->getUser();

            $command = new CreateArticle($id, $articleDto->getTitle(), $articleDto->getContent(), $user);
            $this->messageBus->dispatch($command);
        }

        return $this->render('createArticleForm.html.twig', [
            'form' => $form,
        ]);
    }
}
