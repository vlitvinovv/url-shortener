<?php

namespace App\Analytic\Infrastructure\Repository;

use App\Analytic\Domain\Entity\LinkStat;
use App\Analytic\Domain\Repository\LinkStatRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LinkStatRepository extends AbstractRepository implements LinkStatRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkStat::class);
    }

    public function findByPath(string $path)
    {
        return $this->findOneBy(['path' => $path]);
    }
}