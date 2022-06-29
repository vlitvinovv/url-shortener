<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class DeleteLinkByUlidCommand implements CommandInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}