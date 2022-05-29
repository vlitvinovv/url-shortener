<?php

namespace App\UrlShortener\Application\DTO;

class LinkInputCollectionDTO
{
    private array $elements = [];

    public function add(LinkInputDTO $element): void
    {
        $this->elements[] = $element;
    }

    public function getAll(): array
    {
        return $this->elements;
    }

    public function next(): LinkInputDTO
    {
        return next($this->elements);
    }
}