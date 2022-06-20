<?php

class DiscountCalculatorTest
{
    public function shouldApplyWhenValueIsAboveMinimumTest()
    {
        $discountCalculator = new DiscountCalculator();

        $totalValue = 130;
        $totalValueWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 110;
        $this->assertEquals($expectedValue, $totalValueWithDiscount);
    }

    public function shouldNotApplyWhenValueIsBellowMinimumTest()
    {
        $discountCalculator = new DiscountCalculator();

        $totalValue = 90;
        $totalValueWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 90;
        $this->assertEquals($expectedValue, $totalValueWithDiscount);
    }
    
    public function assertEquals($expectedValue, $actualValue)
    {
        if ($expectedValue !== $actualValue) {
            $message = "Expected: $expectedValue but got: $actualValue";
            throw new Exception($message);
        }

        echo "Test passed! \n";
    }
}
