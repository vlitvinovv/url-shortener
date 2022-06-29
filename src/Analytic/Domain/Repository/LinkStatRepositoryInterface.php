<?php

namespace App\Analytic\Domain\Repository;

interface LinkStatRepositoryInterface
{
    public function findByPath(string $path);
}