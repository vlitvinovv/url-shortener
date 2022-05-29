<?php

namespace App\UrlShortener\Application\DTO;

use App\UrlShortener\Domain\Entity\Link;

class LinkOutputDTO
{
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
        return $linkOutputDTO;
    }
}