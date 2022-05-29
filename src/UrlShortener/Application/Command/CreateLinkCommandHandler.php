<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\UrlShortener\Application\DTO\LinkInputDTO;
use App\UrlShortener\Application\DTO\LinkOutputDTO;
use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;
use App\UrlShortener\Domain\Service\UrlShortenerServiceInterface;
use Symfony\Component\Uid\Ulid;

class CreateLinkCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly LinkRepositoryInterface $linkRepository, private readonly UrlShortenerServiceInterface $urlShortener)
    {

    }

    public function __invoke(CreateLinkCommand $command): array
    {
        $linkInputs = $command->linkInputCollectionDTO->getAll();

        $linksOutput = [];
        /** @var LinkInputDTO $linkInput */
        foreach ($linkInputs as $linkInput) {
            $hash = $this->urlShortener->createHash();
            $ulid = Ulid::generate();

            $link = new Link(
                $ulid,
                $linkInput->longUrl,
                $hash,
                $linkInput->title
            );

            $linksOutput[] = LinkOutputDTO::fromLink($this->urlShortener->getShortUrlByHash($link->getHash()), $link);

            $this->linkRepository->add($link);
        }

        return $linksOutput;
    }
}