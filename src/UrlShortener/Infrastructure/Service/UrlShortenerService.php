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

    public function createShortPath(): string
    {
        do {
            $hash = $this->randomStringGeneratorGenerator->generate(8);
            $existingLink = $this->linkRepository->findOneBy(['path' => $hash]);
        } while($existingLink !== null);

        return $hash;
    }

    public function getShortUrlByPath(string $path): string
    {
        return $this->router->generate('long_url_by_path', ['path' => $path], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}