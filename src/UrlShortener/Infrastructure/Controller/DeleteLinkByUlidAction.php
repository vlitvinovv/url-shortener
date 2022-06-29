<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Command\DeleteLinkByUlidCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteLinkByUlidAction extends ApiController
{
    #[Route('/links/{ulid}', name: "delete_link", methods: ['DELETE'])]
    public function __invoke(string $ulid): JsonResponse
    {
        $result = $this->dispatch(
            new DeleteLinkByUlidCommand(
                $ulid
            )
        );

        if (is_null($result)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }


        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}