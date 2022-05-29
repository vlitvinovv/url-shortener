<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;

class DeleteLinkByUlidCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly LinkRepositoryInterface $linkRepository)
    {
    }

    public function __invoke(DeleteLinkByUlidCommand $command): ?bool
    {
        $link = $this->linkRepository->findOneBy(['ulid' => $command->ulid]);

        if (is_null($link)) {
            return null;
        }

        $this->linkRepository->remove($link);

        return true;
    }
}