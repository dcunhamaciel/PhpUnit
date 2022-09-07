<?php

namespace PaymentBundle\Test\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use PaymentBundle\Service\Gateway;
use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;

class GatewayTest extends TestCase
{
    public function testShouldNotPayWhenAuthenticationFail()
    {
        $user = 'test';
        $password = 'invalid-password';

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $location, $data)
            {
                return $this->fakeHttpClientSend($method, $location, $data);
            }
        ));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay('Diego Maciel', 4090607254337350, new DateTime('now'), 100);

        $this->assertEquals(false, $paid);
    }

    public function testShouldNotPayWhenFailOnGateway()
    {
        $user = 'test';
        $password = 'valid-password';

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $location, $data)
            {
                return $this->fakeHttpClientSend($method, $location, $data);
            }
        ));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay('Diego Maciel', 4090607254337350, new DateTime('now'), 100);

        $this->assertEquals(false, $paid);
    }
    
    public function testShouldSuccessfullyPayWhenGatewayReturnOk()
    {
        $user = 'test';
        $password = 'valid-password';

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $location, $data)
            {
                return $this->fakeHttpClientSend($method, $location, $data);
            }
        ));

        $logger = $this->createMock(LoggerInterface::class);

        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay('Diego Maciel', 9999999999999999, new DateTime('now'), 100);

        $this->assertEquals(true, $paid);
    }

    public function fakeHttpClientSend($method, $location, $data)
    {
        switch ($location) {
            case Gateway::BASE_URL . '/authenticate':
                if ($data['password'] != 'valid-password') {
                    return null;
                }

                return 'my-token';
            case Gateway::BASE_URL . '/pay':
                if ($data['credit_card_number'] != 9999999999999999) {
                    return ['paid' => false];
                }

                return ['paid' => true];
        }
    }
}
