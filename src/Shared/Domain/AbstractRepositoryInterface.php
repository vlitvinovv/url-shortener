<?php

namespace App\Shared\Domain;

interface AbstractRepositoryInterface
{
    public function add($entity, bool $flush = false): void;

    public function remove($entity, bool $flush = false): void;
}