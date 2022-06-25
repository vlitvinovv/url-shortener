<?php

namespace App\UrlShortener\Domain\Repository;

use App\UrlShortener\Domain\Entity\Link;

interface LinkRepositoryInterface
{
    public function findByUlid(string $ulid): ?Link;

    public function findLongUrlByPath(string $path): ?string;
}