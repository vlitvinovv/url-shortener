<?php

namespace App\UrlShortener\Application\Query;

use App\Shared\Application\AMQP\RabbitMqProducerInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\UrlShortener\Domain\Repository\LinkRepositoryInterface;

class GetLongUrlByPathQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly LinkRepositoryInterface $linkRepository, private readonly RabbitMqProducerInterface $producer)
    {
    }

    public function __invoke(GetLongUrlByPathQuery $query)
    {
        $longUrl = $this->linkRepository->findLongUrlByPath($query->path);

        if (null === $longUrl) {
            return null;
        }

        $this->producer->publish(json_encode($query), 'link_view', 'link_view');

        return $longUrl;
    }
}