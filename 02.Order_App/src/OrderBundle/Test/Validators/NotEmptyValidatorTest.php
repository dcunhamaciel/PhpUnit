<?php

namespace OrderBundle\Validators\Test;

use PHPUnit\Framework\TestCase;
use OrderBundle\Validators\NotEmptyValidator;

class NotEmptyValidatorTest extends TestCase 
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid(string $value, bool $expectedResult)
    {
        $notEmptyValidator = new NotEmptyValidator($value);

        $isValid = $notEmptyValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider()
    {
        return [
            "shouldBeValidWhenValueIsNotEmpty" => ["value" => "Valid Value", "expected" => true],
            "shouldNotBeValidWhenValueIsEmpty" => ["value" => "", "expectedResult" => false]            
        ];
    }
}
