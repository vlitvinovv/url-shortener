<?php

namespace App\UrlShortener\Domain\Repository;

use App\UrlShortener\Domain\Entity\Link;

interface LinkRepositoryInterface
{
    public function add(Link $link, bool $flush = false): void;

    public function findUrlByHash(string $hash): ?string;
}