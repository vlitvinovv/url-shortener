<?php

namespace App\UrlShortener\Application\Query;

use App\Shared\Application\Query\QueryInterface;

class GetLongUrlByPathQuery implements QueryInterface
{
    public function __construct(public readonly string $path, public readonly string $userIp, public readonly string $userAgent)
    {
    }
}