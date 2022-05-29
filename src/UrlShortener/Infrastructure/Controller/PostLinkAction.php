<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Command\CreateLinkCommand;
use App\UrlShortener\Application\DTO\LinkInputCollectionDTO;
use App\UrlShortener\Application\DTO\LinkInputDTO;
use App\UrlShortener\Application\DTO\LinkOutputDTO;
use App\UrlShortener\Domain\Entity\Link;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostLinkAction extends ApiController
{
    #[Route('/links', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());

        $urlCollection = new LinkInputCollectionDTO();
        if (is_array($content)) {
            foreach ($content as $item) {
                $url = new LinkInputDTO($item->long_url, $item->title ?? null);
                $urlCollection->add($url);
            }
        } else {
            $urlCollection->add(new LinkInputDTO($content->long_url, $content->title ?? null));
        }

        $results = $this->dispatch(
            new CreateLinkCommand(
                $urlCollection
            )
        );

        $responseBody = count($results) > 1 ? $results : $results[0];

        return new JsonResponse($responseBody, Response::HTTP_CREATED);
    }
}