<?php

namespace App\UrlShortener\Domain\Entity;

use App\UrlShortener\Infrastructure\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 26)]
    private $ulid;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    public function __construct(string $ulid, string $name)
    {
        $this->ulid = $ulid;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
