<?php

namespace Plugin\EccubePaymentLite42\EventListener\EventSubscriber\Admin;

use Eccube\Event\TemplateEvent;
use Eccube\Request\Context;
use Plugin\EccubePaymentLite42\Entity\Config;
use Plugin\EccubePaymentLite42\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddRegularNav implements EventSubscriberInterface
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var ConfigRepository
     */
    private $configRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        Context $context,
        ConfigRepository $configRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->context = $context;
        $this->configRepository = $configRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerArgumentsEvent $event)
    {
        if (!$this->context->isAdmin()) {
            return;
        }
        /** @var Config $Config */
        $Config = $this->configRepository->find(1);
        if (!$Config->getRegular()) {
            return;
        }
        if (!$event->getRequest()->attributes->has('_template')) {
            return;
        }
        /* @var Template $template */
        $template = $event->getRequest()->attributes->get('_template');
        $this->eventDispatcher->addListener($template->getTemplate(), function (TemplateEvent $templateEvent) {
            $templateEvent->addSnippet('@EccubePaymentLite42/admin/Nav/regular_nav.twig');
        });
    }
}
