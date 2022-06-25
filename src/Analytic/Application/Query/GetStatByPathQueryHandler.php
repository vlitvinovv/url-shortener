<?php

namespace App\Analytic\Application\Query;

use App\Analytic\Application\DTO\LinkStatDTO;
use App\Analytic\Domain\Repository\LinkStatRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetStatByPathQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly LinkStatRepositoryInterface $linkViewStatRepository)
    {
    }

    public function __invoke(GetStatByPathQuery $query): ?LinkStatDTO
    {
        $linkStat = $this->linkViewStatRepository->findByPath($query->path);

        return $linkStat !== null ? LinkStatDTO::fromEntity($linkStat) : null;
    }
}