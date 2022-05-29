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
        $link = $this->linkRepository->findOneBy(['ulid' => $query->ulid]);

        if (is_null($link)) {
            return null;
        }

        return LinkOutputDTO::fromLink($this->urlShortener->getShortUrlByHash($link->getHash()), $link);
    }
}