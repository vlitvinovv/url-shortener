<?php

namespace App\Analytic\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class AddLinkViewCommand implements CommandInterface
{
    public function __construct(public readonly string $path, public readonly string $userIp, public readonly string $userAgent)
    {
    }
}