<?php

namespace App\UrlShortener\Infrastructure\Service;

use App\UrlShortener\Domain\Service\UrlShortenerServiceInterface;
use App\UrlShortener\Infrastructure\Repository\LinkRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlShortenerService implements UrlShortenerServiceInterface
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly RandomStringGeneratorGenerator $randomStringGeneratorGenerator,
        private readonly UrlGeneratorInterface $router
    )
    {
    }

    public function createHash(): string
    {
        do {
            $hash = $this->randomStringGeneratorGenerator->generate(8);
            $existingLink = $this->linkRepository->findOneBy(['hash' => $hash]);
        } while($existingLink !== null);

        return $hash;
    }

    public function getShortUrlByHash(string $hash): string
    {
        return $this->router->generate('url_by_hash', ['hash' => $hash], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}