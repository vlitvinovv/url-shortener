<?php

namespace App\UrlShortener\Domain\Service;

interface UrlShortenerServiceInterface
{
    public function createShortPath(): string;

    public function getShortUrlByPath(string $path): string;
}