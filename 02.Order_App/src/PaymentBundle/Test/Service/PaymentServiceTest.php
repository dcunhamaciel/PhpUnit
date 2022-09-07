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

class PaymentServiceTest extends TestCase
{
    public function testShouldSaveWhenGatewayReturnOkWithRetries()
    {
        $gateway = $this->createMock(Gateway::class);
        $paymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);

        $customer = $this->createMock(Customer::class);
        $item = $this->createMock(Item::class);
        $creditCard = $this->createMock(CreditCard::class);

        $paymentService  = new PaymentService($gateway, $paymentTransactionRepository);
       
        $gateway
            ->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(false, false, true));
        
        $paymentTransactionRepository
            ->expects($this->once())
            ->method('save');

        $paymentService->pay($customer, $item, $creditCard);
    }
}
