<?php

namespace OrderBundle\Test\Service;

use OrderBundle\Entity\Customer;
use OrderBundle\Service\CustomerCategoryService;
use OrderBundle\Service\LightUserCategory;
use OrderBundle\Service\HeavyUserCategory;
use OrderBundle\Service\MediumUserCategory;
use OrderBundle\Service\NewUserCategory;
use PHPUnit\Framework\TestCase;

class CustomerCategoryServiceTest extends TestCase
{
    private Customer $customer;
    private CustomerCategoryService $customerCategoryService;

    public function setup(): void
    {
        $this->customer = new Customer();
        $this->customerCategoryService = new CustomerCategoryService();
        $this->customerCategoryService->addCategory(new HeavyUserCategory());
        $this->customerCategoryService->addCategory(new MediumUserCategory());
        $this->customerCategoryService->addCategory(new LightUserCategory());
        $this->customerCategoryService->addCategory(new NewUserCategory());
    }

    /**
     * @test
     */
    public function customerShouldBeNewUser(): void
    {
        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_NEW_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeLightUser(): void
    {
        $this->customer->setTotalOrders(5);
        $this->customer->setTotalRatings(1);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_LIGHT_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeMediumUser(): void
    {
        $this->customer->setTotalOrders(20);
        $this->customer->setTotalRatings(5);
        $this->customer->setTotalRecommendations(1);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_MEDIUM_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeHeavyUser(): void
    {
        $this->customer->setTotalOrders(50);
        $this->customer->setTotalRatings(10);
        $this->customer->setTotalRecommendations(5);

        $usageCategory = $this->customerCategoryService->getUsageCategory($this->customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_HEAVY_USER, $usageCategory);
    }
}
