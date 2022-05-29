<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Query\QueryInterface;
use App\Shared\Infrastructure\Bus\CommandBus;
use App\Shared\Infrastructure\Bus\QueryBus;

abstract class ApiController
{
    public function __construct
    (
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    ) {

    }

    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->execute($query);
    }

    protected function dispatch(CommandInterface $command)
    {
        return $this->commandBus->execute($command);
    }
}