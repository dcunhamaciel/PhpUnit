<?php

namespace PaymentBundle\Test\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use PaymentBundle\Service\Gateway;
use PaymentBundle\Service\PaymentService;
use PaymentBundle\Repository\PaymentTransactionRepository;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use OrderBundle\Entity\CreditCard;
use PaymentBundle\Exception\PaymentErrorException;

class PaymentServiceTest extends TestCase
{
    private $gateway;
    private $paymentTransactionRepository;
    private $paymentService;

    private $customer;
    private $item;
    private $creditCard;
    
    public function setUp(): void
    {
        $this->gateway = $this->createMock(Gateway::class);
        $this->paymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);

        $this->paymentService  = new PaymentService($this->gateway, $this->paymentTransactionRepository);

        $this->customer = $this->createMock(Customer::class);
        $this->item = $this->createMock(Item::class);
        $this->creditCard = $this->createMock(CreditCard::class);
    }

    public function tearDown(): void
    {
        unset($this->gateway);
    }

    public function testShouldSaveWhenGatewayReturnOkWithRetries()
    {     
        $this->gateway
            ->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(false, false, true));
        
        $this->paymentTransactionRepository
            ->expects($this->once())
            ->method('save');

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }

    public function testShouldThrowExceptionWhenGatewayFails()
    {      
        $this->gateway
            ->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(false, false, false));
        
        $this->paymentTransactionRepository
            ->expects($this->never())
            ->method('save');

        $this->expectException(PaymentErrorException::class);

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }
}
