<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\UrlShortener\Application\DTO\LinkInputCollectionDTO;

class CreateLinkCommand implements CommandInterface
{
    public function __construct(public readonly LinkInputCollectionDTO $linkInputCollectionDTO)
    {
    }
}