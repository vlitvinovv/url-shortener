<?php

namespace App\UrlShortener\Application\Query;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;

class GetUrlByHashQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly LinkRepositoryInterface $linkRepository)
    {
    }

    public function __invoke(GetUrlByHashQuery $query)
    {
        return $this->linkRepository->findUrlByHash($query->hash);
    }
}