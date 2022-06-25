<?php

namespace App\Analytic\Application\Query;

use App\Shared\Application\Query\QueryInterface;

class GetStatByPathQuery implements QueryInterface
{
    public function __construct(public readonly string $path)
    {
    }
}