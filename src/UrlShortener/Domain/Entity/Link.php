<?php

namespace App\UrlShortener\Domain\Entity;

use App\UrlShortener\Infrastructure\Repository\LinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $path;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'links_tags')]
    #[ORM\JoinColumn(name: "link_ulid", referencedColumnName: "ulid")]
    #[ORM\InverseJoinColumn(name: "tag_ulid", referencedColumnName: "ulid")]
    private $tags;

    public function __construct(string $ulid, string $longUrl, string $path, ?string $title)
    {
        $this->ulid = $ulid;
        $this->longUrl = $longUrl;
        $this->path = $path;
        $this->title = $title;

        $this->tags = new ArrayCollection();
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

    public function getPath(): string
    {
        return $this->path;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
