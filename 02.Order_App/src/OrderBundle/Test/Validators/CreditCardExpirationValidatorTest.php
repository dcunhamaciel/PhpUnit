<?php

namespace OrderBundle\Validators\Test;

use DataTime;
use DateTime;
use PHPUnit\Framework\TestCase;
use OrderBundle\Validators\CreditCardExpirationValidator;

class CreditCardExpirationValidatorTest extends TestCase 
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {
        $creditCardExpirationDate = new DateTime($value);

        $creditCardExpirationValidator = new CreditCardExpirationValidator($creditCardExpirationDate);

        $isValid = $creditCardExpirationValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider()
    {
        return [
            "shouldBeValidWhenDateIsNotExpired" => ["value" => "2029-01-01", "expectedResult" => true],
            "shouldNotBeValidWhenDateIsExpired" => ["value" => "2022-01-01", "expectedResult" => false]
        ];
    }
}
