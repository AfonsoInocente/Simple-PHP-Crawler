<?php

namespace App\Utils;

class CookieExtractor
{
    public function findCookie(string $cookieName, string $html): string
    {
        if (!$cookieName) {
            throw new \InvalidArgumentException("O Nome do Cookie a ser procurado deve ser preenchido.", 400);
        }

        if (!$html) {
            throw new \InvalidArgumentException("O HTML para a busca deve ser enviado.", 400);
        }

        preg_match_all('/^Set-Cookie:\s*([^;]*)/im', $html, $matches);
        foreach ($matches[1] as $item) {
            if (substr($item, 0, 9) == $cookieName) {
                return $item;
            }
        }

        throw new \Exception("Nenhum Cookie encontrado.", 404);
    }
}
