<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use App\Utils\CookieExtractor;
use App\Infra\ExternalRequest;

class CookieExtractorTest extends TestCase
{
    public function testRetrieveCookie()
    {
        $ExternalRequest = new ExternalRequest(TARGET_URL);

        $preparedCurl = $ExternalRequest->prepareToGetData();
        $response = $ExternalRequest->execute($preparedCurl);

        $cookieToFind = 'PHPSESSID';
        $CookieExtractor = new CookieExtractor();
        $cookie = $CookieExtractor->findCookie($cookieToFind, $response);

        $this->assertEquals($cookieToFind, substr($cookie, 0, 9));
    }

    public function testExceptionAreThrownForEmptyCookieName()
    {
        $cookieName = '';
        $response   = '<html></html>';

        $CookieExtractor = new CookieExtractor();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O Nome do Cookie a ser procurado deve ser preenchido.');

        $CookieExtractor->findCookie($cookieName, $response);
    }

    public function testExceptionAreThrownForNonExistingCookie()
    {
        $cookieName = 'PHPSESSID';
        $ExternalRequest = new ExternalRequest(TARGET_URL);

        $preparedCurl = $ExternalRequest->prepareToGetData();
        $response = $ExternalRequest->execute($preparedCurl);
        $response = str_replace($cookieName, '', $response);

        $CookieExtractor = new CookieExtractor();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum Cookie encontrado.');

        $CookieExtractor->findCookie($cookieName, $response);
    }

    public function testExceptionAreThrownForEmptyHtml()
    {
        $cookieName = 'PHPSESSID';
        $response   = '';

        $CookieExtractor = new CookieExtractor();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O HTML para a busca deve ser enviado.');

        $CookieExtractor->findCookie($cookieName, $response);
    }
}
