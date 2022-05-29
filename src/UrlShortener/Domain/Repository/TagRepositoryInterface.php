<?php

namespace App\UrlShortener\Domain\Repository;

use App\UrlShortener\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function add(Tag $entity, bool $flush = false): void;

    public function remove(Tag $entity, bool $flush = false): void;
}