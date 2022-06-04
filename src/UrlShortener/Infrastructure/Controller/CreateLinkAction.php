<?php

namespace App\UrlShortener\Infrastructure\Controller;

use App\Shared\Application\Exception\ValidationException;
use App\Shared\Infrastructure\Controller\ApiController;
use App\UrlShortener\Application\Command\CreateLinkCommand;
use App\UrlShortener\Application\DTO\LinkInputDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateLinkAction extends ApiController
{
    #[Route('/links', methods: ['POST'])]
    public function __invoke(Request $request, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $content = json_decode($request->getContent());

        if (is_array($content)) {
            $urls = $serializer->deserialize($request->getContent(), LinkInputDTO::class.'[]', 'json');
            $violations = $validator->validate($urls);
        } else {
            $url = $serializer->deserialize($request->getContent(), LinkInputDTO::class, 'json');
            $violations = $validator->validate($url);

            $urls = [];
            $urls[] = $url;
        }

        if (\count($violations)) {
            throw new ValidationException($violations);
        }

        $results = $this->dispatch(
            new CreateLinkCommand(
                $urls
            )
        );

        $responseBody = count($results) > 1 ? $results : $results[0];

        return new JsonResponse($responseBody, Response::HTTP_CREATED);
    }
}