<?php

namespace App\UrlShortener\Infrastructure\Service;

use App\UrlShortener\Domain\Service\RandomStringGeneratorInterface;

class RandomStringGeneratorGenerator implements RandomStringGeneratorInterface
{
    public function generate(int $length = 16): string
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $inputLength = strlen($permittedChars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCharacter = $permittedChars[random_int(0, $inputLength - 1)];
            $randomString .= $randomCharacter;
        }

        return $randomString;
    }
}