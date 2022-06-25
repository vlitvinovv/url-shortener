<?php

namespace App\Analytic\Domain\Repository;

interface UniqueViewRepositoryInterface
{
    public function hasUniqueView(string $linkViewStatUlid, string $userIp, string $userAgent);
}