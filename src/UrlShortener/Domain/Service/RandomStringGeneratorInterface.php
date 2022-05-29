<?php

namespace App\UrlShortener\Domain\Service;

interface RandomStringGeneratorInterface
{
    public function generate(int $length): string;
}