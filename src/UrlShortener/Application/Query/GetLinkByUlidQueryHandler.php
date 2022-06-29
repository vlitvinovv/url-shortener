<?php

namespace App\UrlShortener\Application\Query;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\UrlShortener\Application\DTO\LinkOutputDTO;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;
use App\UrlShortener\Domain\Service\UrlShortenerServiceInterface;

class GetLinkByUlidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly LinkRepositoryInterface $linkRepository, private readonly UrlShortenerServiceInterface $urlShortener)
    {
    }

    public function __invoke(GetLinkByUlidQuery $query): ?LinkOutputDTO
    {
        $link = $this->linkRepository->findByUlid($query->ulid);

        return $link !== null ?
            LinkOutputDTO::fromLink($this->urlShortener->getShortUrlByPath($link->getPath()), $link) :
            null;
    }
}