<?php

namespace App\UrlShortener\Application\DTO;

use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Entity\Tag;
use Doctrine\Common\Collections\Collection;

class LinkOutputDTO
{
    public readonly array $tags;

    public function __construct(
        public readonly string $ulid,
        public readonly string $longUrl,
        public readonly string $shortUrl,
        public readonly ?string $title
    )
    {
    }

    public static function fromLink(string $shortUrl, Link $link): self
    {
        $linkOutputDTO = new self($link->getUlid(), $link->getLongUrl(), $shortUrl, $link->getTitle());

        $tags = [];
        /** @var Tag $tag */
        foreach ($link->getTags() as $tag) {
            $tags[] = $tag->getName();
        }

        $linkOutputDTO->tags = $tags;

        return $linkOutputDTO;
    }
}