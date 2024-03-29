<?php

declare(strict_types=1);

namespace App\Article\UI\Action;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\UI\Form\CreateArticleType;
use App\Article\UI\Form\Data\CreateArticleData;
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
        $form = $this->createForm(CreateArticleType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('createArticleForm.html.twig', ['form' => $form]);
        }

        /** @var CreateArticleData $articleDto */
        $articleDto = $form->getData();
        $id = Uuid::v4();

        /** @var User $user */
        $user = $this->getUser();

        $command = new CreateArticleCommand($id, $articleDto->title, $articleDto->content, $user);
        $this->messageBus->dispatch($command);

        return $this->render('home.html.twig');
    }
}
