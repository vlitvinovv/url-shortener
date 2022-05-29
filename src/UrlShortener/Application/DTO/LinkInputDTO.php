<?php

namespace App\UrlShortener\Application\DTO;

class LinkInputDTO
{
    public function __construct(public readonly string $longUrl, public readonly ?string $title)
    {
    }
}