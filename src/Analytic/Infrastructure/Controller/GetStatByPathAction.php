<?php

namespace App\Analytic\Infrastructure\Controller;

use App\Analytic\Application\Query\GetStatByPathQuery;
use App\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetStatByPathAction extends ApiController
{
    #[Route('/stats/{path}', name: "stat_by_short_path", methods: ['GET'])]
    public function __invoke(string $path)
    {
        $stat = $this->ask(
            new GetStatByPathQuery($path)
        );

        if (null === $stat) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->serialize($stat), Response::HTTP_OK, [], true);
    }
}