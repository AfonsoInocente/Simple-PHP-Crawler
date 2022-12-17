<?php

namespace App\Controllers;

class Controller {
    public function __construct(
        public object $RequestController,
        public object $InterfaceController,
        public object $TokenConversor
    ) {}

    public function getInitialData(): string {
        $preparedCurl = $this->RequestController->prepareToGetData();
        $response = $this->RequestController->execute($preparedCurl);
        return $response;
    }

    public function loadResponse($response): array {
        $htmlResponseAndInteractor = $this->InterfaceController->loadHTMLData($response);
        return $htmlResponseAndInteractor;
    }

    public function getCookie(string $HTML): string {
        return $this->InterfaceController->findCookie($HTML);
    }

    public function getToken(object $HTMLInteractor): string {
        return $this->InterfaceController->getTokenValue($HTMLInteractor);
    }

    public function convertToken(string $actualToken) {
        $convertedToken = $this->TokenConversor->convert($actualToken);
        return $convertedToken;
    }

    public function getLastData(string $token, string $cookie): string {
        $preparedCurl = $this->RequestController->prepareToPostData($token, $cookie);
        $postResponse = $this->RequestController->execute($preparedCurl);
        return $postResponse;
    }

    public function getAnswer(string $element): string {
        return $this->InterfaceController->findTheAnswer($element);
    }

    public function tellTheAnswer($answer, $cookie, $initialToken, $token): void {
        echo 'A resposta final é: ' . $answer . '.';

        echo '<br/><br/>Mais informações:<br/>';
        echo 'Cookie: ' . substr($cookie, 10) . ';<br/>';
        echo 'Token Inicial: ' . $initialToken . ';<br/>';
        echo 'Token Convertido: ' . $token . ';<br/>';
    }
}