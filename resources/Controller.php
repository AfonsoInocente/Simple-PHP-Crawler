<?php

class Controller {
    public $_RequestController;
    public $_InterfaceController;
    public $_TokenConversor;

    function __construct(
        object $RequestController,
        object $InterfaceController,
        object $TokenConversor
    ) {
        $this->_RequestController = $RequestController;
        $this->_InterfaceController = $InterfaceController;
        $this->_TokenConversor = $TokenConversor;
    }

    public function getInitialData(): string {
        $preparedCurl = $this->_RequestController->prepareToGetData();
        $response = $this->_RequestController->execute($preparedCurl);
        return $response;
    }

    public function loadResponse($response): array {
        $htmlResponseAndInteractor = $this->_InterfaceController->loadHTMLData($response);
        return $htmlResponseAndInteractor;
    }

    public function getCookie(string $HTML): string {
        return $this->_InterfaceController->findCookie($HTML);
    }

    public function getToken(object $HTMLInteractor): string {
        return $this->_InterfaceController->getTokenValue($HTMLInteractor);
    }

    public function convertToken(string $actualToken) {
        $convertedToken = $this->_TokenConversor->convert($actualToken);
        return $convertedToken;
    }

    public function getLastData(string $token, string $cookie): string {
        $preparedCurl = $this->_RequestController->prepareToPostData($token, $cookie);
        $postResponse = $this->_RequestController->execute($preparedCurl);
        return $postResponse;
    }

    public function getAnswer(string $element): string {
        return $this->_InterfaceController->findTheAnswer($element);
    }

    public function tellTheAnswer($answer, $cookie, $initialToken, $token): void {
        echo 'A resposta final é: ' . $answer . '.';

        echo '<br/><br/>Mais informações:<br/>';
        echo 'Cookie: ' . substr($cookie, 10) . ';<br/>';
        echo 'Token Inicial: ' . $initialToken . ';<br/>';
        echo 'Token Convertido: ' . $token . ';<br/>';
    }
}