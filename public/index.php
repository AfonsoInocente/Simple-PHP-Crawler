<?php
use \App\Utils\TokenConversor;
use \App\Utils\CookieExtractor;
use \App\Infra\ExternalRequest;
use \App\Infra\Interactor;
use \App\Controllers\Controller;

require_once('../vendor/autoload.php');

$HTMLInteractor  = new DOMDocument();
$TokenConversor  = new TokenConversor();
$CookieExtractor  = new CookieExtractor();

$ExternalRequest = new ExternalRequest(TARGET_URL);
$Interactor      = new Interactor($HTMLInteractor);

$CONTROLLER = new Controller(
    $ExternalRequest,
    $Interactor,
    $TokenConversor,
    $CookieExtractor
);

$initialResponse = $CONTROLLER->getInitialData();
$loadedInitialResponse = $CONTROLLER->loadResponse($initialResponse);

$cookie = $CONTROLLER->getCookie("PHPSESSID", $loadedInitialResponse['HTML']);

$HTMLAdapterInteractor = new DOMXpath($loadedInitialResponse['Interactor']);
$token = $CONTROLLER->getToken($HTMLAdapterInteractor);

$convertedToken = $CONTROLLER->convertToken($token);

$lastResponse = $CONTROLLER->getLastData($convertedToken, $cookie);
$answer = $CONTROLLER->getAnswer($lastResponse);

$CONTROLLER->tellTheAnswer($answer, $cookie, $token, $convertedToken);