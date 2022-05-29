<?php

namespace App\UrlShortener\Domain\Service;

interface UrlShortenerServiceInterface
{
    public function createHash(): string;

    public function getShortUrlByHash(string $hash): string;
}