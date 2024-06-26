<?php

namespace Plugin\EccubePaymentLite42\Service\GmoEpsilonRequest;

use GuzzleHttp\Client;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonRequestService;

class RequestCard3Service
{
    /**
     * @var GmoEpsilonRequestService
     */
    private $gmoEpsilonRequestService;

    public function __construct(
        GmoEpsilonRequestService $gmoEpsilonRequestService
    ) {
        $this->gmoEpsilonRequestService = $gmoEpsilonRequestService;
    }

    public function send($url)
    {
        $client = new Client();
        $Response = $client
            ->get($url);
        if ($Response->getReasonPhrase() === 'OK') {
            return true;
        }

        return false;
    }
}
