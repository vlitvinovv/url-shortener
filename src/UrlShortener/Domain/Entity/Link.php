<?php

namespace App\UrlShortener\Domain\Entity;

use App\UrlShortener\Infrastructure\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
class Link
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 26)]
    private $ulid;

    #[ORM\Column(type: 'string', length: 255)]
    private $longUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $hash;

    public function __construct(string $ulid, string $longUrl, string $hash, ?string $title)
    {
        $this->ulid = $ulid;
        $this->longUrl = $longUrl;
        $this->hash = $hash;
        $this->title = $title;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
