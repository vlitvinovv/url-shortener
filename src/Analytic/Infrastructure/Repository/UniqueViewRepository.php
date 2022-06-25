<?php

namespace App\Analytic\Infrastructure\Repository;

use App\Analytic\Domain\Entity\LinkStat;
use App\Analytic\Domain\Entity\UniqueView;
use App\Analytic\Domain\Repository\UniqueViewRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UniqueViewRepository extends AbstractRepository implements UniqueViewRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniqueView::class);
    }

    public function hasUniqueView(string $linkViewStatUlid, string $userIp, string $userAgent): bool
    {
        $qb = $this->createQueryBuilder('uv');
        return $qb->select('count(uv.ulid)')
            ->where('uv.linkStatView = :link_view_stat')
            ->andWhere('uv.userAgent = :user_agent')
            ->andWhere('uv.userIp = :user_ip')
            ->setParameter(':link_view_stat', $linkViewStatUlid)
            ->setParameter(':user_agent', $userAgent)
            ->setParameter(':user_ip', $userIp)
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }
}