<?php

namespace App\UrlShortener\Infrastructure\Repository;

use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;


class LinkRepository extends ServiceEntityRepository implements LinkRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function add(Link $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Link $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUrlByHash(string $hash): ?string
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select('l.longUrl')
            ->where($qb->expr()->eq('l.hash', ':hash'))
            ->setParameter('hash', $hash);

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
