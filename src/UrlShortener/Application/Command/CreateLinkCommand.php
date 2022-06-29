<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class CreateLinkCommand implements CommandInterface
{
    public function __construct(public readonly array $linkInputDTOs)
    {
    }
}