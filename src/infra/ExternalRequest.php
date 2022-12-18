<?php

namespace App\Infra;

class ExternalRequest
{
    public function __construct(private string $url)
    {
    }

    public function prepareToGetData(): object
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);

        return $curl;
    }

    public function prepareToPostData(string $token, string $cookie): object
    {
        if (!$token) {
            throw new \InvalidArgumentException("O Token não pode ser vazio.", 400);
        }

        if (!$cookie) {
            throw new \InvalidArgumentException("O Cookie não pode ser vazio.", 400);
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'token=' . $token);
        curl_setopt($curl, CURLOPT_REFERER, $this->url);
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        return $curl;
    }

    public function execute(object $curl): string
    {
        if (!is_a($curl, 'CurlHandle')) {
            throw new \InvalidArgumentException('O Objeto enviado deve ser do tipo CurlHandle.', 400);
        }

        if (curl_errno($curl)) {
            throw new \Exception(curl_error($curl), 400);
        }

        $response = curl_exec($curl);
        $this->finish($curl);

        if (!$response) {
            throw new \Exception("Nenhum retorno obtido.", 404);
        }

        return $response;
    }

    private function finish(object $curl): void
    {
        curl_close($curl);
    }
}
