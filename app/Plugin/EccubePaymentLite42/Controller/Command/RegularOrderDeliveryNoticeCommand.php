<?php

namespace Plugin\EccubePaymentLite42\Controller\Command;

use Plugin\EccubePaymentLite42\Entity\Config;
use Plugin\EccubePaymentLite42\Entity\RegularOrder;
use Plugin\EccubePaymentLite42\Repository\ConfigRepository;
use Plugin\EccubePaymentLite42\Repository\RegularOrderRepository;
use Plugin\EccubePaymentLite42\Service\IsActiveRegularService;
use Plugin\EccubePaymentLite42\Service\Mail\RegularOrderNoticeMailService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegularOrderDeliveryNoticeCommand extends Command
{
    protected static $defaultName = 'gmo_epsilon_4:regular_order:delivery_notice';
    /**
     * @var SymfonyStyle
     */
    private $io;
    /**
     * @var RegularOrderRepository
     */
    private $regularOrderRepository;
    /**
     * @var ConfigRepository
     */
    private $configRepository;
    /**
     * @var RegularOrderNoticeMailService
     */
    private $regularOrderNoticeMailService;
    /**
     * @var IsActiveRegularService
     */
    private $isActiveRegularService;

    public function __construct(
        RegularOrderRepository $regularOrderRepository,
        ConfigRepository $configRepository,
        RegularOrderNoticeMailService $regularOrderNoticeMailService,
        IsActiveRegularService $isActiveRegularService
    ) {
        parent::__construct();
        $this->regularOrderRepository = $regularOrderRepository;
        $this->configRepository = $configRepository;
        $this->regularOrderNoticeMailService = $regularOrderNoticeMailService;
        $this->isActiveRegularService = $isActiveRegularService;
    }

    protected function configure()
    {
        $this->setDescription('Regular order delivery notice');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->isActiveRegularService->isActive()) {
            $this->io->text('=== Regular setting is not Active. ===');

            return 0;
        }
        $this->io->text('=== RegularOrderDeliveryNotice start. ===');
        // 事前お知らせメール送信
        /** @var Config $Config */
        $Config = $this->configRepository->find(1);
        $regularDeliveryNotificationEmailDate = $Config->getRegularDeliveryNotificationEmailDays();
        if (is_null($regularDeliveryNotificationEmailDate)) {
            $this->io->text('=== regular delivery notification email date is not found. ===');
            $this->io->text('=== RegularOrderDeliveryNoticeCommand end. ===');

            return 0;
        }
        $deliveryNoticeStartDate = new \DateTime('today');
        $deliveryNoticeStartDate->modify('+'.$Config->getRegularDeliveryNotificationEmailDays().' day');
        $deliveryNoticeEndDate = new \DateTime('tomorrow');
        $deliveryNoticeEndDate->modify('+'.$Config->getRegularDeliveryNotificationEmailDays().' day');
        $rePaymentStartDate = new \DateTime('today');
        $rePaymentStartDate->modify('+'.$Config->getNextDeliveryDaysAfterRePayment().' day');
        $rePaymentEndDate = new \DateTime('tomorrow');
        $rePaymentEndDate->modify('+'.$Config->getNextDeliveryDaysAfterRePayment().' day');

        /** @var RegularOrder[] $RegularOrders */
        $RegularOrders = $this
            ->regularOrderRepository
            ->getRegularOrderForDeliveryNotice(
                clone $deliveryNoticeStartDate,
                clone $deliveryNoticeEndDate,
                clone $rePaymentStartDate,
                clone $rePaymentEndDate
            );
        foreach ($RegularOrders as $RegularOrder) {
            $this->regularOrderNoticeMailService->sendMail($RegularOrder);
            $this->io->text('=== 定期ID: '.$RegularOrder->getId().' send mail success ===');
        }
        $this->io->text('=== RegularOrderDeliveryNotice end. ===');

        return 1;
    }
}
