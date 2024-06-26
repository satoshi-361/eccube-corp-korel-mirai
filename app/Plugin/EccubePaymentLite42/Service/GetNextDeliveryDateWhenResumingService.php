<?php

namespace Plugin\EccubePaymentLite42\Service;

use Plugin\EccubePaymentLite42\Entity\Config;
use Plugin\EccubePaymentLite42\Repository\ConfigRepository;

class GetNextDeliveryDateWhenResumingService
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        ConfigRepository $configRepository
    ) {
        $this->configRepository = $configRepository;
    }

    public function get()
    {
        /** @var Config $Config */
        $Config = $this->configRepository->find(1);
        $nextDeliveryDays = $Config->getNextDeliveryDaysAtRegularResumption();
        $dateTime = new \DateTime('today');
        $dateTime->modify('+'.$nextDeliveryDays.' day');

        return $dateTime;
    }
}
