<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class HelloWorldAction extends AbstractController
{
    #[Route('/api/hello-world', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return $this->json(['message' => 'Hello, world']);
    }
}
