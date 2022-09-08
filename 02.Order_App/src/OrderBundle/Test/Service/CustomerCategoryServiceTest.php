<?php

namespace OrderBundle\Test\Service;

use PHPUnit\Framework\TestCase;
use OrderBundle\Entity\Customer;
use OrderBundle\Service\CustomerCategoryService;

class CustomerCategoryServiceTest extends TestCase
{
    /**
     * @test
     */
    public function customerShouldBeNewUser()
    {
        $customerCategoryService = new CustomerCategoryService();

        $customer = new Customer();
        $usageCategory = $customerCategoryService->getUsageCategory($customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_NEW_USER, $usageCategory);
    }
}
