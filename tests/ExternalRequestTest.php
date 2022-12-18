<?php
use PHPUnit\Framework\TestCase;

use \App\Infra\ExternalRequest;

require_once('vendor/autoload.php');

class ExternalRequestTest extends TestCase {
    public function testIfResponseIsAHtml()
    {
        $ExternalRequest = new ExternalRequest(TARGET_URL);
        $preparedCurl = $ExternalRequest->prepareToGetData();
        $response = $ExternalRequest->execute($preparedCurl);
        $isHtml = ($response != strip_tags($response));

        $this->assertEquals(true, $isHtml);
    }

    public function testExceptionAreThrownForPassAnEmptyObjectDifferentOfCurlToExecuteFunction()
    {
        $ExternalRequest = new ExternalRequest(TARGET_URL);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O Objeto enviado deve ser do tipo CurlHandle.');

        $emptyObject = (object) [];
        $ExternalRequest->execute($emptyObject);
    }

    public function testExceptionAreThrownForPassEmptyTokenToPreparePostData()
    {
        $ExternalRequest = new ExternalRequest(TARGET_URL);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O Token não pode ser vazio.');

        $token = '';
        $cookie = 'cookie';
        $ExternalRequest->prepareToPostData($token, $cookie);
    }

    public function testExceptionAreThrownForPassEmptyCookieToPreparePostData()
    {
        $ExternalRequest = new ExternalRequest(TARGET_URL);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O Cookie não pode ser vazio.');

        $token = 'token';
        $cookie = '';
        $ExternalRequest->prepareToPostData($token, $cookie);
    }
}