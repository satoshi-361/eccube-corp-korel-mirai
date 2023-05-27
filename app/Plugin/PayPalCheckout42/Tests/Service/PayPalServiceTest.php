<?php

namespace Plugin\PayPalCheckout42\Tests\Service;

use Eccube\Tests\Service\AbstractServiceTestCase;
use Plugin\PayPalCheckout42\Service\PayPalService;

/**
 * Class PayPalServiceTest
 * @package Plugin\PayPalCheckout42\Tests\Service
 */
class PayPalServiceTest extends AbstractServiceTestCase
{
    /**
     * @var PayPalService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = self::$container->get(PayPalService::class);
    }

    /**
     * @test
     */
    public function instance()
    {
        $this->assertInstanceOf(PayPalService::class, $this->service);
    }
}
