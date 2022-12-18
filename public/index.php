<?php

use App\Utils\TokenConversor;
use App\Utils\CookieExtractor;
use App\Infra\ExternalRequest;
use App\Infra\Interactor;
use App\Controllers\Controller;

require_once __DIR__ . '/../vendor/autoload.php';
$htmlInteractor  = new DOMDocument();
$tokenConversor  = new TokenConversor();
$cookieExtractor  = new CookieExtractor();
$externalRequest = new ExternalRequest(TARGET_URL);
$interactor      = new Interactor($htmlInteractor);
$controller = new Controller($externalRequest, $interactor, $tokenConversor, $cookieExtractor);
$initialResponse = $controller->getInitialData();
$loadedInitialResponse = $controller->loadResponse($initialResponse);
$cookie = $controller->getCookie("PHPSESSID", $loadedInitialResponse['HTML']);
$htmlAdapterInteractor = new DOMXpath($loadedInitialResponse['Interactor']);
$token = $controller->getToken($htmlAdapterInteractor);
$convertedToken = $controller->convertToken($token);
$lastResponse = $controller->getLastData($convertedToken, $cookie);
$answer = $controller->getAnswer($lastResponse);
$controller->tellTheAnswer($answer, $cookie, $token, $convertedToken);
