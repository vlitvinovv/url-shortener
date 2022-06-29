<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Query\GetLinkByUlidQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetLinkByUlidAction extends ApiController
{
    #[Route('/links/{ulid}', name: "get_link", methods: ['GET'])]
    public function __invoke(string $ulid): JsonResponse
    {
        $linkOutputDTO = $this->ask(
            new GetLinkByUlidQuery(
                $ulid
            )
        );

        if (is_null($linkOutputDTO)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }


        return new JsonResponse($this->serialize($linkOutputDTO), Response::HTTP_OK, [], true);
    }
}