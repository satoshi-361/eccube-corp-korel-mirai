<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Service;

use Eccube\Common\EccubeConfig;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Customer;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\MailHistoryRepository;
use Eccube\Repository\MailTemplateRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

use Eccube\Service\MailService as BaseService;

class MailService extends BaseService
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var MailTemplateRepository
     */
    protected $mailTemplateRepository;

    /**
     * @var MailHistoryRepository
     */
    protected $mailHistoryRepository;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var BaseInfo
     */
    protected $BaseInfo;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /** @var ContainerInterface */
    protected $container;

    /**
     * MailService constructor.
     *
     * @param MailerInterface $mailer
     * @param MailTemplateRepository $mailTemplateRepository
     * @param MailHistoryRepository $mailHistoryRepository
     * @param BaseInfoRepository $baseInfoRepository
     * @param EventDispatcherInterface $eventDispatcher
     * @param \Twig\Environment $twig
     * @param EccubeConfig $eccubeConfig
     * @param ContainerInterface $container
     */
    public function __construct(
        MailerInterface $mailer,
        MailTemplateRepository $mailTemplateRepository,
        MailHistoryRepository $mailHistoryRepository,
        BaseInfoRepository $baseInfoRepository,
        EventDispatcherInterface $eventDispatcher,
        \Twig\Environment $twig,
        EccubeConfig $eccubeConfig,
        ContainerInterface $container
    ) {
        parent::__construct( $mailer, $mailTemplateRepository, $mailHistoryRepository, $baseInfoRepository,
        $eventDispatcher, $twig, $eccubeConfig, $container );
    }

    /**
     * Send review mail to administrator when a review is posted by customer
     *
     * @param $Customer 会員情報
     */
    public function sendReviewMail(Customer $Customer, $review_id)
    {
        log_info('レビュー投稿メール送信開始');

        $body = $this->twig->render('Mail/review.twig', [
            'Customer' => $Customer,
            'review_id' => $review_id,
            'BaseInfo' => $this->BaseInfo,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.'レビューの確認をお願いします。')
            ->from(new Address($Customer->getEmail()))
            ->to($this->convertRFCViolatingEmail($this->BaseInfo->getEmail01()))
            ->text($body);

        try {
            $this->mailer->send($message);
            log_info('レビュー投稿完了メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }
}
