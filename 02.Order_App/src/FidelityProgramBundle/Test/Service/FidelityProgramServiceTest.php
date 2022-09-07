<?php

namespace FidelityProgramBundle\Test\Service;

use PHPUnit\Framework\TestCase;
use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;

class FidelityProgramServiceTest extends TestCase
{
    public function testShouldSaveWhenReceivePoints()
    {
        $orderValue = 50;
        $pointsToReceive = 100;
        $allMessages = [];
        $expectedMessages = [
            'Checking points for customer',
            'Customer received points'
        ];

        $pointsRepository = $this->createMock(PointsRepository::class);        
        $pointsRepository->expects($this->once())->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn($pointsToReceive);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->method('log')->will($this->returnCallback(
            function($message) use (&$allMessages) 
            {
                $allMessages[] = $message;
            }
        ));

        $customer = $this->createMock(Customer::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        $fidelityProgramService->addPoints($customer, $orderValue);

        $this->assertEquals($expectedMessages, $allMessages);
    }

    public function testShouldNotSaveWhenReceiveZeroPoints()
    {
        $orderValue = 20;
        $pointsToReceive = 0;
        $allMessages = [];
        $expectedMessages = ['Checking points for customer'];

        $pointsRepository = $this->createMock(PointsRepository::class);        
        $pointsRepository->expects($this->never())->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn($pointsToReceive);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->method('log')->will($this->returnCallback(
            function($message) use (&$allMessages) 
            {
                $allMessages[] = $message;
            }
        ));

        $customer = $this->createMock(Customer::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        $fidelityProgramService->addPoints($customer, $orderValue);

        $this->assertEquals($expectedMessages, $allMessages);
    }    
}
