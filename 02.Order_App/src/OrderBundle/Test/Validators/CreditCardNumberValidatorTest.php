<?php

namespace OrderBundle\Validators\Test;

use PHPUnit\Framework\TestCase;
use OrderBundle\Validators\CreditCardNumberValidator;

class CreditCardNumberValidatorTest extends TestCase 
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {
        $creditCardNumberValidator = new CreditCardNumberValidator($value);

        $isValid = $creditCardNumberValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider()
    {
        return [
            "shouldBeValidWhenValueIsCreditCard" => ["value" => 5131606495306222, "expectedResult" => true],
            "shouldBeValidWhenValueIsCreditCardAsString" => ["value" => "5131606495306222", "expectedResult" => true],
            "shouldNotBeValidWhenValueIsEmpty" => ["value" => "", "expectedResult" => false],
            "shouldNotBeValidWhenValueIsNotCreditCard" => ["value" => 35464611, "expectedResult" => false]
        ];
    }
}
