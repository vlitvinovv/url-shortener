<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Query\GetLongUrlByPathQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectToLongUrlByPathAction extends ApiController
{
    #[Route('/{path}', name: "long_url_by_path", methods: ['GET'])]
    public function __invoke(string $path, Request $request): Response
    {
        $url = $this->ask(
            new GetLongUrlByPathQuery(
                $path,
                $request->getClientIp(),
                $request->headers->get('User-Agent')
            )
        );

        if (is_null($url)) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new RedirectResponse($url);
    }
}