<?php

namespace App\Controllers;

use App\Utils\TokenConversor;
use App\Utils\CookieExtractor;
use App\Infra\ExternalRequest;
use App\Infra\Interactor;

class Controller
{
    public function __construct(
        private ExternalRequest $requestController,
        private Interactor $interfaceController,
        private TokenConversor $tokenConversor,
        private CookieExtractor $cookieExtractor
    ) {
    }

    public function getInitialData(): string
    {
        $preparedCurl = $this->requestController->prepareToGetData();
        $response = $this->requestController->execute($preparedCurl);
        return $response;
    }

    public function loadResponse($response): array
    {
        $htmlResponseAndInteractor = $this->interfaceController->loadHTMLData($response);
        return $htmlResponseAndInteractor;
    }

    public function getCookie(string $cookieName, string $HTML): string
    {
        return $this->cookieExtractor->findCookie($cookieName, $HTML);
    }

    public function getToken(object $htmlInteractor): string
    {
        return $this->interfaceController->getTokenValue($htmlInteractor);
    }

    public function convertToken(string $actualToken)
    {
        $convertedToken = $this->tokenConversor->convert($actualToken);
        return $convertedToken;
    }

    public function getLastData(string $token, string $cookie): string
    {
        $preparedCurl = $this->requestController->prepareToPostData($token, $cookie);
        $postResponse = $this->requestController->execute($preparedCurl);
        return $postResponse;
    }

    public function getAnswer(string $element): string
    {
        return $this->interfaceController->findTheAnswer($element);
    }

    public function tellTheAnswer($answer, $cookie, $initialToken, $token): void
    {
        echo 'A resposta final é: ' . $answer . '.';

        echo '<br/><br/>Mais informações:<br/>';
        echo 'Cookie: ' . substr($cookie, 10) . ';<br/>';
        echo 'Token Inicial: ' . $initialToken . ';<br/>';
        echo 'Token Convertido: ' . $token . ';<br/>';
    }
}
