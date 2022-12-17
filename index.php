<?php
require_once('resources/Controller.php');
require_once('resources/Interactor.php');
require_once('resources/ExternalRequest.php');
require_once('resources/TokenConversor.php');

$url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';

$HTMLInteractor  = new DOMDocument();
$TokenConversor  = new TokenConversor();
$ExternalRequest = new ExternalRequest($url);

$Interactor = new Interactor($HTMLInteractor);
$CONTROLLER  = new Controller($ExternalRequest, $Interactor, $TokenConversor);

$initialResponse = $CONTROLLER->getInitialData();
$loadedInitialResponse = $CONTROLLER->loadResponse($initialResponse);

$cookie = $CONTROLLER->getCookie($loadedInitialResponse['HTML']);

$HTMLAdapterInteractor = new DOMXpath($loadedInitialResponse['Interactor']);
$token = $CONTROLLER->getToken($HTMLAdapterInteractor);

$convertedToken = $CONTROLLER->convertToken($token);

$lastResponse = $CONTROLLER->getLastData($convertedToken, $cookie);
$answer = $CONTROLLER->getAnswer($lastResponse);

$CONTROLLER->tellTheAnswer($answer, $cookie, $token, $convertedToken);