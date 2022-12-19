<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use App\Infra\ExternalRequest;
use App\Infra\Interactor;

class InteractorTest extends TestCase
{
    public function testRetrieveToken()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <body>
                <input type="text" name="token" id="token" value="y17755385y7y8878z3v1249172wz6v4x">
            </body>
        </html>';

        $loadHtml = $Interactor->loadHTMLData($html);

        $AdapterInteractor = new \DOMXpath($loadHtml['Interactor']);
        $token = $Interactor->getTokenValue($AdapterInteractor);

        $expectedValue = 'y17755385y7y8878z3v1249172wz6v4x';
        $this->assertEquals($expectedValue, $token);
    }

    public function testExceptionAreThrownForNotExistentTokenInput()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <body>
            </body>
        </html>';

        $loadHtml = $Interactor->loadHTMLData($html);

        $AdapterInteractor = new \DOMXpath($loadHtml['Interactor']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('O elemento que contém o Token não foi identificado.');

        $Interactor->getTokenValue($AdapterInteractor);
    }

    public function testExceptionAreThrownForMoreThanOneInputWithTokenId()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <body>
                <input type="text" name="token" id="token">
                <input type="text" name="token" id="token">
            </body>
        </html>';

        $loadHtml = $Interactor->loadHTMLData($html);

        $AdapterInteractor = new \DOMXpath($loadHtml['Interactor']);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Foi encontrado mais de um Elemento com o ID Token. Por favor, verifique o código e tente novamente.');

        $Interactor->getTokenValue($AdapterInteractor);
    }

    public function testExceptionAreThrownForTokenInputWithNonExistingValue()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <body>
                <input type="text" name="token" id="token">
            </body>
        </html>';

        $loadHtml = $Interactor->loadHTMLData($html);

        $AdapterInteractor = new \DOMXpath($loadHtml['Interactor']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não foi possível identificar um valor para o Token. Por favor, verifique o código e tente novamente.');

        $Interactor->getTokenValue($AdapterInteractor);
    }

    public function testRetrieveAnswer()
    {
        $DOMDocument = new \DOMDocument();
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

    public function testExceptionAreThrownForNotExistentAnswerInput()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <head></head>
            <body></body>
        </html>';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('O elemento que contém a Resposta não foi identificado.');

        $Interactor->findTheAnswer($html);
    }

    public function testExceptionAreThrownForAnswerInputWithNonExistingValue()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '<html>
            <head></head>
            <body>
                RESPOSTA: <span id="answer"></span>
                <br>
                <a href="http://localhost/testes/crawly-2022/treino/">Voltar</a>
            </body>
        </html>';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A Resposta está nula. Por favor, verifique o código e tente novamente.');

        $Interactor->findTheAnswer($html);
    }

    public function testExceptionAreThrownForEmptyAnswerHTML()
    {
        $DOMDocument = new \DOMDocument();
        $Interactor = new Interactor($DOMDocument);

        $html = '';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar um HTML para prosseguir.');

        $Interactor->findTheAnswer($html);
    }
}
