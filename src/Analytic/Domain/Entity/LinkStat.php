<?php

namespace App\Analytic\Domain\Entity;

use App\Analytic\Infrastructure\Repository\LinkStatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkStatRepository::class)]
class LinkStat
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 26)]
    private string $ulid;

    #[ORM\Column(type: 'bigint')]
    private int $totalViewsCount = 0;

    #[ORM\Column(type: 'bigint')]
    private int $uniqueViewsCount = 0;

    #[ORM\Column(type: 'string', length: 255)]
    private string $path;

    public function __construct(string $ulid, string $path)
    {
        $this->ulid = $ulid;
        $this->path = $path;
    }

    public function incrementTotalViews()
    {
        $this->totalViewsCount++;
    }

    public function incrementUniqueViews()
    {
        $this->uniqueViewsCount++;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getTotalViewsCount(): int
    {
        return $this->totalViewsCount;
    }

    public function getUniqueViewsCount(): int
    {
        return $this->uniqueViewsCount;
    }
}