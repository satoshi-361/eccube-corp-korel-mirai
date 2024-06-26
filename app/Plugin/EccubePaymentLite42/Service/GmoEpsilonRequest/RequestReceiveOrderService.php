<?php

namespace Plugin\EccubePaymentLite42\Service\GmoEpsilonRequest;

use Eccube\Common\Constant;
use Eccube\Common\EccubeConfig;
use Eccube\Repository\PluginRepository;
use Plugin\EccubePaymentLite42\Repository\ConfigRepository;
use Plugin\EccubePaymentLite42\Service\GetProductInformationFromOrderService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonOrderNoService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonRequestService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonUrlService;

class RequestReceiveOrderService
{
    /**
     * @var GmoEpsilonRequestService
     */
    private $gmoEpsilonRequestService;
    /**
     * @var GmoEpsilonUrlService
     */
    private $gmoEpsilonUrlService;
    /**
     * @var object|null
     */
    private $Config;
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    /**
     * @var GetProductInformationFromOrderService
     */
    private $getProductInformationFromOrderService;
    /**
     * @var GmoEpsilonOrderNoService
     */
    private $gmoEpsilonOrderNoService;
    /**
     * @var pluginRepository
     */
    private $pluginRepository;

    public function __construct(
        GmoEpsilonRequestService $gmoEpsilonRequestService,
        ConfigRepository $configRepository,
        GmoEpsilonUrlService $gmoEpsilonUrlService,
        EccubeConfig $eccubeConfig,
        GetProductInformationFromOrderService $getProductInformationFromOrderService,
        GmoEpsilonOrderNoService $gmoEpsilonOrderNoService,
        PluginRepository $pluginRepository
    ) {
        $this->gmoEpsilonRequestService = $gmoEpsilonRequestService;
        $this->Config = $configRepository->get();
        $this->gmoEpsilonUrlService = $gmoEpsilonUrlService;
        $this->eccubeConfig = $eccubeConfig;
        $this->getProductInformationFromOrderService = $getProductInformationFromOrderService;
        $this->gmoEpsilonOrderNoService = $gmoEpsilonOrderNoService;
        $this->pluginRepository = $pluginRepository;
    }

    public function handle($Customer, $processCode, $route, $Order = null)
    {
        $status = 'NG';
        $PluginVersion = $this->pluginRepository->findByCode('eccubepaymentlite42')->getVersion();

        $parameters = [
            'contract_code' => $this->Config->getContractCode(),
            'user_id' => $Customer->getId(),
            'user_name' => $Customer->getName01().' '.$Customer->getName02(),
            'user_mail_add' => $Customer->getEmail(),
            'st_code' => '11000-0000-00000-00000-00000-00000-00000',
            'process_code' => $processCode,
            'memo1' => $route,
            'memo2' => 'EC-CUBE_' . Constant::VERSION . '_' . $PluginVersion . "_" . date('YmdHis'),
            'xml' => 1,
            'version' => 1,
        ];
        if ($processCode === 2) {
            $gmoEpsilonOrderNo = $this->gmoEpsilonOrderNoService->create($Order->getId());
            $itemInformation = $this->getProductInformationFromOrderService->handle($Order);
            $parameters['item_code'] = $itemInformation['item_code'];
            $parameters['item_name'] = $itemInformation['item_name'];
            $parameters['order_number'] = $gmoEpsilonOrderNo;
            $parameters['mission_code'] = 1;
            $parameters['item_price'] = (int) $Order->getPaymentTotal();
        }

        $response = $this->gmoEpsilonRequestService->sendData(
            $this->gmoEpsilonUrlService->getUrl(
                'receive_order3'
            ),
            $parameters
        );

        $message = $this->gmoEpsilonRequestService->getXMLValue($response, 'RESULT', 'ERR_DETAIL');

        $result = (int) $this->gmoEpsilonRequestService->getXMLValue($response, 'RESULT', 'RESULT');
        if ($result === $this->eccubeConfig['gmo_epsilon']['receive_parameters']['result']['ok']) {
            $message = '正常終了';
            $status = 'OK';
        }

        return [
            'result' => (int) $this->gmoEpsilonRequestService->getXMLValue($response, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonRequestService->getXMLValue($response, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
            'url' => $this->gmoEpsilonRequestService->getXMLValue($response, 'RESULT', 'REDIRECT'),
        ];
    }
}
