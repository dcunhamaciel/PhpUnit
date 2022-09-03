<?php

namespace OrderBundle\Entity\Test;

use PHPUnit\Framework\TestCase;
use OrderBundle\Entity\Customer;

class CustomerTest extends TestCase 
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsAllowedToOrder($isActive, $isBlocked, $expectedAllowed)
    {
        $customer = new Customer($isActive, $isBlocked, "Diego Maciel", "(35) 9999-8888");

        $isAllowed = $customer->isAllowedToOrder();

        $this->assertEquals($expectedAllowed, $isAllowed);
    }

    public function valueProvider()
    {
        return [
            "shouldBeAllowedWhenIsActiveAndNotBlocked" => [
                "isActive" => true, 
                "isBlocked" => false,
                "expectedAllowed" => true
            ],
            "shouldNotBeAllowedWhenIsActiveAndButItBlocked" => [
                "isActive" => true, 
                "isBlocked" => true,
                "expectedAllowed" => false
            ],
            "shouldNotBeAllowedWhenIsNotActive" => [
                "isActive" => false,
                "isBlocked" => false,
                "expectedAllowed" => false
            ],
            "shouldNotBeAllowedWhenIsNotActiveAndIsBlocked" => [
                "isActive" => false,
                "isBlocked" => true,
                "expectedAllowed" => false
            ]            
        ];
    }
}
