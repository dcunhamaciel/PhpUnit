<?php

namespace FidelityProgramBundle\Test\Service;

use PHPUnit\Framework\TestCase;
use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use OrderBundle\Entity\Customer;

class FidelityProgramServiceTest extends TestCase
{
    public function testShouldSaveWhenReceivePoints()
    {
        $orderValue = 50;
        $pointsToReceive = 100;

        $pointsRepository = $this->createMock(PointsRepository::class);        
        $pointsRepository->expects($this->once())->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn($pointsToReceive);

        $customer = $this->createMock(Customer::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator);

        $fidelityProgramService->addPoints($customer, $orderValue);
    }

    public function testShouldNotSaveWhenReceiveZeroPoints()
    {
        $orderValue = 20;
        $pointsToReceive = 0;

        $pointsRepository = $this->createMock(PointsRepository::class);        
        $pointsRepository->expects($this->never())->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn($pointsToReceive);

        $customer = $this->createMock(Customer::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator);

        $fidelityProgramService->addPoints($customer, $orderValue);
    }    
}
