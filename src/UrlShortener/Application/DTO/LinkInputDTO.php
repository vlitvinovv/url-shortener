<?php

namespace App\UrlShortener\Application\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class LinkInputDTO
{
    #[Assert\NotBlank]
    #[SerializedName("long_url")]
    public string $longUrl;

    #[Assert\NotBlank]
    public ?string $title;

    #[Assert\Sequentially([
        new Assert\Type('array'),
        new Assert\All([
            new Assert\Type('string'),
            new Assert\NotBlank,
            new Assert\Length(min: 1)
        ])
    ])]
    public $tags;
}