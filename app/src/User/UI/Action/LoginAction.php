<?php

declare(strict_types=1);

namespace App\User\UI\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginAction extends AbstractController
{
    #[Route('/api/login', methods: 'GET')]
    public function __invoke(): Response
    {
        return $this->redirect('https://accounts.atcloud.pro/en/authorize?service=test-blog.dev');
    }
}
