<?php

namespace App\Infra;

class ExternalRequest {
    public function __construct(private string $URL)
    {}

    public function prepareToGetData(): object {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);

        return $curl;
    }

    public function prepareToPostData(string $token, string $cookie): object {
        if (!$token) {
            throw new Exception("O Token não pode ser nulo");
        }

        if (!$cookie) {
            throw new Exception("O Cookie não pode ser nulo");
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'token=' . $token );
        curl_setopt($curl, CURLOPT_REFERER, $this->URL);
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        return $curl;
    }

    public function execute(object $curl): string {
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }

        $response = curl_exec($curl);
        $this->finish($curl);

        if (!$response) {
            throw new Exception("Nenhum retorno obtido.");
        }

        return $response;
    }

    private function finish(object $curl): void {
        curl_close($curl);
    }
}
