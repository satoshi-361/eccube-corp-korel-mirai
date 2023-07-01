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
use Eccube\Entity\MailHistory;
use Eccube\Entity\Order;
use Eccube\Entity\Shipping;

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
        $toEmail = 'contact@yokohama-mirai.jp';

        $body = $this->twig->render('Mail/review.twig', [
            'Customer' => $Customer,
            'review_id' => $review_id,
            'BaseInfo' => $this->BaseInfo,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.'レビューの確認をお願いします。')
            ->from(new Address($Customer->getEmail()))
            ->to($this->convertRFCViolatingEmail($toEmail))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->text($body);

        try {
            $this->mailer->send($message);
            log_info('レビュー投稿完了メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }

    /**
     * Send order mail.
     *
     * @param \Eccube\Entity\Order $Order 受注情報
     *
     * @return Email
     */
    public function sendOrderMail(Order $Order)
    {
        log_info('受注メール送信開始');

        $orderEmail = 'order@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_order_mail_template_id']);

        $body = $this->twig->render($MailTemplate->getFileName(), [
            'Order' => $Order,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($orderEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Order->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->replyTo($orderEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'Order' => $Order,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        $event = new EventArgs(
            [
                'message' => $message,
                'Order' => $Order,
                'MailTemplate' => $MailTemplate,
                'BaseInfo' => $this->BaseInfo,
            ],
            null
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::MAIL_ORDER);

        try {
            $this->mailer->send($message);
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }

        $MailHistory = new MailHistory();
        $MailHistory->setMailSubject($message->getSubject())
            ->setMailBody($message->getTextBody())
            ->setOrder($Order)
            ->setSendDate(new \DateTime());

        // HTML用メールの設定
        $htmlBody = $message->getHtmlBody();
        if (!empty($htmlBody)) {
            $MailHistory->setMailHtmlBody($htmlBody);
        }

        $this->mailHistoryRepository->save($MailHistory);

        log_info('受注メール送信完了');

        return $message;
    }

    /**
     * 発送通知メールを送信する.
     * 発送通知メールは受注ごとに送られる
     *
     * @param Shipping $Shipping
     *
     * @throws \Twig_Error
     */
    public function sendShippingNotifyMail(Shipping $Shipping)
    {
        log_info('出荷通知メール送信処理開始', ['id' => $Shipping->getId()]);

        $orderEmail = 'order@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_shipping_notify_mail_template_id']);

        /** @var Order $Order */
        $Order = $Shipping->getOrder();
        $body = $this->getShippingNotifyMailBody($Shipping, $Order, $MailTemplate->getFileName());

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($orderEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Order->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->replyTo($orderEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->getShippingNotifyMailBody($Shipping, $Order, $htmlFileName, true);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        try {
            $this->mailer->send($message);
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }

        $MailHistory = new MailHistory();
        $MailHistory->setMailSubject($message->getSubject())
                ->setMailBody($message->getTextBody())
                ->setOrder($Order)
                ->setSendDate(new \DateTime());

        // HTML用メールの設定
        $htmlBody = $message->getHtmlBody();
        if (!empty($htmlBody)) {
            $MailHistory->setMailHtmlBody($htmlBody);
        }

        $this->mailHistoryRepository->save($MailHistory);

        log_info('出荷通知メール送信処理完了', ['id' => $Shipping->getId()]);
    }

    /**
     * Send customer confirm mail.
     *
     * @param $Customer 会員情報
     * @param string $activateUrl アクティベート用url
     */
    public function sendCustomerConfirmMail(Customer $Customer, $activateUrl)
    {
        log_info('仮会員登録メール送信開始');

        $contactEmail = 'contact@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_entry_confirm_mail_template_id']);

        $body = $this->twig->render($MailTemplate->getFileName(), [
            'Customer' => $Customer,
            'BaseInfo' => $this->BaseInfo,
            'activateUrl' => $activateUrl,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($contactEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Customer->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->bcc($contactEmail)
            ->replyTo($contactEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
                'activateUrl' => $activateUrl,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        $event = new EventArgs(
            [
                'message' => $message,
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
                'activateUrl' => $activateUrl,
            ],
            null
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::MAIL_CUSTOMER_CONFIRM);

        try {
            $this->mailer->send($message);
            log_info('仮会員登録メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }

    /**
     * Send customer complete mail.
     *
     * @param $Customer 会員情報
     */
    public function sendCustomerCompleteMail(Customer $Customer)
    {
        log_info('会員登録完了メール送信開始');

        $contactEmail = 'contact@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_entry_complete_mail_template_id']);

        $body = $this->twig->render($MailTemplate->getFileName(), [
            'Customer' => $Customer,
            'BaseInfo' => $this->BaseInfo,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($contactEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Customer->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->replyTo($contactEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        $event = new EventArgs(
            [
                'message' => $message,
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
            ],
            null
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::MAIL_CUSTOMER_COMPLETE);

        try {
            $this->mailer->send($message);
            log_info('会員登録完了メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }

    /**
     * Send password reset notification mail.
     *
     * @param $Customer 会員情報
     * @param string $reset_url
     */
    public function sendPasswordResetNotificationMail(Customer $Customer, $reset_url)
    {
        log_info('パスワード再発行メール送信開始');

        $contactEmail = 'contact@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_forgot_mail_template_id']);
        $body = $this->twig->render($MailTemplate->getFileName(), [
            'BaseInfo' => $this->BaseInfo,
            'Customer' => $Customer,
            'expire' => $this->eccubeConfig['eccube_customer_reset_expire'],
            'reset_url' => $reset_url,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($contactEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Customer->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->replyTo($contactEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'BaseInfo' => $this->BaseInfo,
                'Customer' => $Customer,
                'expire' => $this->eccubeConfig['eccube_customer_reset_expire'],
                'reset_url' => $reset_url,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        $event = new EventArgs(
            [
                'message' => $message,
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
                'resetUrl' => $reset_url,
            ],
            null
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::MAIL_PASSWORD_RESET);

        try {
            $this->mailer->send($message);
            log_info('パスワード再発行メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }

    }

    /**
     * Send password reset notification mail.
     *
     * @param $Customer 会員情報
     * @param string $password
     */
    public function sendPasswordResetCompleteMail(Customer $Customer, $password)
    {
        log_info('パスワード変更完了メール送信開始');

        $contactEmail = 'contact@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_reset_complete_mail_template_id']);

        $body = $this->twig->render($MailTemplate->getFileName(), [
            'BaseInfo' => $this->BaseInfo,
            'Customer' => $Customer,
            'password' => $password,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($contactEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Customer->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->bcc($this->BaseInfo->getEmail01())
            ->replyTo($contactEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'BaseInfo' => $this->BaseInfo,
                'Customer' => $Customer,
                'password' => $password,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        $event = new EventArgs(
            [
                'message' => $message,
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
                'password' => $password,
            ],
            null
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::MAIL_PASSWORD_RESET_COMPLETE);

        try {
            $this->mailer->send($message);
            log_info('パスワード変更完了メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }

    /**
     * Send customer complete mail.
     *
     * @param $Customer 会員情報
     */
    public function sendCustomerChangeMail(Customer $Customer)
    {
        log_info('会員登録内容の変更メール送信開始');

        $contactEmail = 'contact@yokohama-mirai.jp';
        $MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_customer_change_mail_template_id']);

        $body = $this->twig->render($MailTemplate->getFileName(), [
            'Customer' => $Customer,
            'BaseInfo' => $this->BaseInfo,
        ]);

        $message = (new Email())
            ->subject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
            ->from(new Address($contactEmail, $this->BaseInfo->getShopName()))
            ->to($this->convertRFCViolatingEmail($Customer->getEmail()))
            ->addTo($this->convertRFCViolatingEmail('nmyuta1127@gmail.com'))
            ->replyTo($contactEmail);

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, [
                'Customer' => $Customer,
                'BaseInfo' => $this->BaseInfo,
            ]);

            $message
                ->text($body)
                ->html($htmlBody);
        } else {
            $message->text($body);
        }

        try {
            $this->mailer->send($message);
            log_info('会員登録内容の変更メール送信完了');
        } catch (TransportExceptionInterface $e) {
            log_critical($e->getMessage());
        }
    }
}
