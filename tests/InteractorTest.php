<?php

namespace App\Infra;

use PHPUnit\Framework\TestCase;

use \App\Infra\ExternalRequest;
use \App\Infra\Interactor;

require_once('../vendor/autoload.php');

class InteractorTest extends TestCase {
    public function testRetrieveToken()
    {
        $DOMDocument = new DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <body>
                <input type="text" name="token" id="token" value="y17755385y7y8878z3v1249172wz6v4x">
            </body>
        </html>';

        $loadHtml = $Interactor->loadHTMLData($html);

        $AdapterInteractor = new DOMXpath($loadHtml['Interactor']);
        $token = $Interactor->getTokenValue($AdapterInteractor);

        $expectedValue = 'y17755385y7y8878z3v1249172wz6v4x';
        $this->assertEquals($expectedValue, $token);
    }

    public function testRetrieveCookie()
    {
        $Interactor = new Interactor();

        $url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';
        $ExternalRequest = new ExternalRequest($url);

        $preparedCurl = $ExternalRequest->prepareToGetData();
        $response = $ExternalRequest->execute($preparedCurl);

        $cookie = $Interactor->findCookie($response);

        $this->assertEquals("PHPSESSID=", substr($cookie, 0, 10));
    }

    public function testRetrieveAnswer()
    {
        $DOMDocument = new DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
        <head></head>
            <body>
                RESPOSTA: <span id="answer">100</span>
                <br>
                <a href="http://localhost/testes/crawly-2022/treino/">Voltar</a>
            </body>
        </html>';

        $answer = $Interactor->findTheAnswer($html);

        $expectedValue = '100';
        $this->assertEquals($expectedValue, $answer);
    }
}