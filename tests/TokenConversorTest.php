<?php
use PHPUnit\Framework\TestCase;

use \App\Utils\TokenConversor;

require_once __DIR__ . '/../vendor/autoload.php';

class TokenConversorTest extends TestCase {
    public function testTokenConversion()
    {
        $TokenConversor = new TokenConversor();
        $convertedToken = $TokenConversor->convert('678x184362yz280x457y93w04y808u37');
        $expectedValue  = '321c815637ba719c542b06d95b191f62';
        $this->assertEquals($expectedValue, $convertedToken);
    }

    public function testExceptionAreThrownForEmptyToken()
    {
        $TokenConversor = new TokenConversor();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O Token deve ser preenchido.');

        $TokenConversor->convert('');
    }
}