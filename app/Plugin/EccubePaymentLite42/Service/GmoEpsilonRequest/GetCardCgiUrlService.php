<?php

namespace Plugin\EccubePaymentLite42\Service\GmoEpsilonRequest;

use Plugin\EccubePaymentLite42\Service\GmoEpsilonRequestService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonUrlService;

class GetCardCgiUrlService
{
    /**
     * @var GmoEpsilonRequestService
     */
    private $gmoEpsilonRequestService;
    /**
     * @var GmoEpsilonUrlService
     */
    private $gmoEpsilonUrlService;

    public function __construct(
        GmoEpsilonRequestService $gmoEpsilonRequestService,
        GmoEpsilonUrlService $gmoEpsilonUrlService
    ) {
        $this->gmoEpsilonRequestService = $gmoEpsilonRequestService;
        $this->gmoEpsilonUrlService = $gmoEpsilonUrlService;
    }

    public function getUrl(array $xmlResponse): string
    {
        return $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'REDIRECT');
    }
}
