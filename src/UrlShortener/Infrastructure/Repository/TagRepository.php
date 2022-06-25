<?php

namespace App\UrlShortener\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\AbstractRepository;
use App\UrlShortener\Domain\Entity\Tag;
use App\UrlShortener\Domain\Repository\TagRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }
}
