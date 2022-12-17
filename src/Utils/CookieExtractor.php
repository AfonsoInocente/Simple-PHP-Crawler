<?php

namespace App\Utils;

class CookieExtractor {
    public function findCookie(string $cookieName, string $html): string {
        preg_match_all('/^Set-Cookie:\s*([^;]*)/im', $html, $matches);
        foreach($matches[1] as $item) {
            if (substr($item, 0, 9 ) == $cookieName) {
                return $item;
            }
        }

        var_dump('chegou aqui');
        exit;

        throw new Exception("Nenhum Cookie encontrado.");
    }
}
