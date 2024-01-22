<?php

declare(strict_types=1);

namespace App\User\UI\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfterLoginAction extends AbstractController
{
    #[Route('/api/after-login', name: 'app_login', methods: 'GET')]
    public function __invoke(Request $request): Response
    {
        return $this->render('home.html.twig');
    }
}
