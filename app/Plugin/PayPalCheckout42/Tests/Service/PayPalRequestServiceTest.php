<?php

namespace Plugin\PayPalCheckout42\Tests\Service;

use Eccube\Tests\Service\AbstractServiceTestCase;
use Plugin\PayPalCheckout42\Service\PayPalRequestService;
use Plugin\PayPalCheckout42\Service\PayPalService;

/**
 * Class PayPalRequestServiceTest
 * @package Plugin\PayPalCheckout42\Tests\Service
 */
class PayPalRequestServiceTest extends AbstractServiceTestCase
{
    /**
     * @var PayPalRequestService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        parent::setUp();
        $service = self::$container->get(PayPalService::class);
        $this->service = $service->client;
    }

    /**
     * @test
     */
    public function instance()
    {
        $this->assertInstanceOf(PayPalRequestService::class, $this->service);
    }
}
