<?php

namespace App\Analytic\Application\DTO;

use App\Analytic\Domain\Entity\LinkStat;
use Symfony\Component\Serializer\Annotation\SerializedName;

class LinkStatDTO
{
    #[SerializedName("total_views")]
    public readonly int $totalViews;

    #[SerializedName("unique_views")]
    public readonly int $uniqueViews;

    public function __construct(int $totalViews, int $uniqueViews)
    {
        $this->totalViews = $totalViews;
        $this->uniqueViews = $uniqueViews;
    }

    public static function fromEntity(LinkStat $linkStat): self
    {
        $dto = new self(
            $linkStat->getTotalViewsCount(),
            $linkStat->getUniqueViewsCount()
        );

        return $dto;
    }
}