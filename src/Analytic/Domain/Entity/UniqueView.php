<?php

namespace App\Analytic\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UniqueView
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 26)]
    private string $ulid;

    #[ORM\Column(type: 'string', length: 39)]
    private string $userIp;

    #[ORM\Column(type: 'string', length: 255)]
    private string $userAgent;

    #[ORM\ManyToOne(targetEntity: LinkStat::class, inversedBy: 'uniqueViews')]
    #[ORM\JoinColumn(name: 'link_view_id', referencedColumnName: 'ulid')]
    private $linkStatView;

    public function __construct(string $ulid, string $userIp, string $userAgent, LinkStat $linkStatView)
    {
        $this->ulid = $ulid;
        $this->userIp = $userIp;
        $this->userAgent = $userAgent;
        $this->linkStatView = $linkStatView;
    }
}