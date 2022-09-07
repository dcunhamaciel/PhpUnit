<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Service\PointsCalculator;
use PHPUnit\Framework\TestCase;

class PointsCalculatorTest extends TestCase
{
    /**
     * @dataProvider valueDataProvider
     */    
    public function testPointsToReceive($value, $expectedPoints)
    {
        $pointsCalculator = new PointsCalculator();

        $pointsReceived = $pointsCalculator->calculatePointsToReceive($value);

        $this->assertEquals($expectedPoints, $pointsReceived);        
    }

    public function valueDataProvider()
    {
        return [
            [120, 6000],
            [80, 2400],
            [60, 1200],
            [20, 0]     
        ];
    }
}
