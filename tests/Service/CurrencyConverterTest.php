<?php

namespace App\Tests\Service;

use App\Service\CurrencyConverter;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    public function testJoinsEndpointPath()
    {
        $converter = new CurrencyConverter;

        $expected = 'https://api.exchangeratesapi.io/latest?base=EUR&symbols=USD';
        $actual = $converter
            ->from(1.0, 'EUR')
            ->to('USD')
            ->getApi();
        
        $this->assertSame($expected, $actual);
    }

    public function testConvertsCurrency()
    {
        $converter = new CurrencyConverter;
        
        $value = 1.0;
        $actual = $converter
            ->from($value, 'EUR')
            ->to('USD')
            ->getValues();
        
        foreach ($actual as $key) {
            $this->assertNotSame($value, $key);
        }
    }
}
