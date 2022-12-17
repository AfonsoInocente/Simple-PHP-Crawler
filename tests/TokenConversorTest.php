<?php

require_once('resources/TokenConversor.php');

use PHPUnit\Framework\TestCase;

class TokenConversorTest extends TestCase {
    public function testTokenConversion()
    {
        $TokenConversor = new TokenConversor();
        $convertedToken = $TokenConversor->convert('678x184362yz280x457y93w04y808u37');
        $expectedValue  = '321c815637ba719c542b06d95b191f62';
        $this->assertEquals($expectedValue, $convertedToken);
    }
}