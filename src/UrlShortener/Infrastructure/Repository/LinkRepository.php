<?php

namespace App\UrlShortener\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\AbstractRepository;
use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;


class LinkRepository extends AbstractRepository implements LinkRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function findByUlid(string $ulid): ?Link
    {
        return $this->findOneBy(['ulid' => $ulid]);
    }

    public function findLongUrlByPath(string $path): ?string
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select('l.longUrl')
            ->where($qb->expr()->eq('l.path', ':path'))
            ->setParameter('path', $path);

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
