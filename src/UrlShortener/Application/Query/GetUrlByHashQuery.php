<?php

namespace App\UrlShortener\Application\Query;

use App\Shared\Application\Query\QueryInterface;

class GetUrlByHashQuery implements QueryInterface
{
    public function __construct(public readonly string $hash)
    {
    }
}