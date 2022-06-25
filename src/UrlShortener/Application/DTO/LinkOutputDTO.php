<?php

namespace App\UrlShortener\Application\DTO;

use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Entity\Tag;
use Symfony\Component\Serializer\Annotation\SerializedName;

class LinkOutputDTO
{
    public readonly string $ulid;

    #[SerializedName("long_url")]
    public readonly string $longUrl;

    #[SerializedName("short_url")]
    public readonly string $shortUrl;

    public readonly ?string $title;

    public readonly array $tags;

    public function __construct(
        string $ulid,
        string $longUrl,
        string $shortUrl,
        ?string $title
    )
    {
        $this->ulid = $ulid;
        $this->longUrl = $longUrl;
        $this->shortUrl = $shortUrl;
        $this->title = $title;
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