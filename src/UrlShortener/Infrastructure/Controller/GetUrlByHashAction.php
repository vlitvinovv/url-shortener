<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Query\GetUrlByHashQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetUrlByHashAction extends ApiController
{
    #[Route('/{hash}', name: "url_by_hash", methods: ['GET'])]
    public function __invoke(string $hash)
    {
        $url = $this->ask(
            new GetUrlByHashQuery(
                $hash
            )
        );

        if (is_null($url)) {
            return new JsonResponse([], 404);
        }

        return new RedirectResponse($url);
    }
}