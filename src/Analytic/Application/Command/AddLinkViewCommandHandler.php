<?php

namespace App\Analytic\Application\Command;

use App\Analytic\Domain\Entity\LinkStat;
use App\Analytic\Domain\Entity\UniqueView;
use App\Analytic\Domain\Repository\LinkStatRepositoryInterface;
use App\Analytic\Domain\Repository\UniqueViewRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use Symfony\Component\Uid\Ulid;

class AddLinkViewCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly LinkStatRepositoryInterface $linkViewStatRepository,
        private readonly UniqueViewRepositoryInterface $uniqueViewRepository
    )
    {
    }

    public function __invoke(AddLinkViewCommand $command)
    {
        $view = $this->linkViewStatRepository->findByPath($command->path);

        if (null === $view) {
            $view = new LinkStat(Ulid::generate(), $command->path);
        }
        $view->incrementTotalViews();

        $hasUniqueView = $this->uniqueViewRepository->hasUniqueView($view->getUlid(), $command->userIp, $command->userAgent);
        if (!$hasUniqueView) {
            $view->incrementUniqueViews();

            $uniqueView = new UniqueView(Ulid::generate(), $command->userIp, $command->userAgent, $view);
            $this->uniqueViewRepository->add($uniqueView);
        }

        $this->linkViewStatRepository->add($view);
    }
}