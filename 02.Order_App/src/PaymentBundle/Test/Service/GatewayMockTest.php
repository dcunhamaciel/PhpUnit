<?php

namespace PaymentBundle\Test\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use PaymentBundle\Service\Gateway;
use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;

class GatewayMockTest extends TestCase
{
    public function testShouldNotPayWhenAuthenticationFail()
    {
        $user = 'test';
        $password = 'invalid-password';

        $name = 'Diego Maciel';
        $creditCardNumber = 4090607254337350;
        $validity = new DateTime('now');
        $value = 100;

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                null
            ]
        ];

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('send')->will($this->returnValueMap($map));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay($name, $creditCardNumber, $validity, $value);

        $this->assertFalse($paid);
    }

    public function testShouldNotPayWhenFailOnGateway()
    {
        $user = 'test';
        $password = 'valid-password';
        $token = 'my-token';

        $name = 'Diego Maciel';
        $creditCardNumber = 4090607254337350;
        $validity = new DateTime('now');
        $value = 100;

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                $token
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCardNumber,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => false]
            ]
        ];

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')->will($this->returnValueMap($map));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay($name, $creditCardNumber, $validity, $value);

        $this->assertFalse($paid);
    }
    
    public function testShouldSuccessfullyPayWhenGatewayReturnOk()
    {
        $user = 'test';
        $password = 'valid-password';
        $token = 'my-token';

        $name = 'Diego Maciel';
        $creditCardNumber = 4090607254337350;
        $validity = new DateTime('now');
        $value = 100;

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                $token
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCardNumber,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => true]
            ]
        ];
        
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')->will($this->returnValueMap($map));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay($name, $creditCardNumber, $validity, $value);

        $this->assertTrue($paid);
    }
}
