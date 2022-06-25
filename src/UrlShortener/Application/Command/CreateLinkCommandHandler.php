<?php

namespace App\UrlShortener\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\UrlShortener\Application\DTO\LinkInputDTO;
use App\UrlShortener\Application\DTO\LinkOutputDTO;
use App\UrlShortener\Domain\Entity\Link;
use App\UrlShortener\Domain\Entity\Tag;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;
use App\UrlShortener\Domain\Repository\TagRepositoryInterface;
use App\UrlShortener\Domain\Service\UrlShortenerServiceInterface;
use Symfony\Component\Uid\Ulid;

class CreateLinkCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly LinkRepositoryInterface $linkRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly UrlShortenerServiceInterface $urlShortener
    )
    {

    }

    public function __invoke(CreateLinkCommand $command): array
    {
        $linkInputs = $command->linkInputDTOs;

        $linksOutput = [];
        /** @var LinkInputDTO $linkInput */
        foreach ($linkInputs as $linkInput) {
            $hash = $this->urlShortener->createShortPath();

            $link = new Link(
                Ulid::generate(),
                $linkInput->longUrl,
                $hash,
                $linkInput->title
            );

            if (isset($linkInput->tags)) {
                foreach ($linkInput->tags as $tagItem) {
                    $tag = $this->tagRepository->findOneBy(['name' => $tagItem]);

                    if (!$tag) {
                        $tag = new Tag(Ulid::generate(), $tagItem);
                        $this->tagRepository->add($tag);
                    }

                    $link->addTag($tag);
                }
            }

            $linksOutput[] = LinkOutputDTO::fromLink($this->urlShortener->getShortUrlByPath($link->getPath()), $link);

            $this->linkRepository->add($link);
        }

        return $linksOutput;
    }
}