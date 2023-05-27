<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Form\Extension;use Eccube\Common\EccubeConfig;use Eccube\Entity\Order;use Eccube\Form\Type\Shopping\OrderType;use Eccube\Repository\PaymentRepository;use Eccube\Repository\PluginRepository;use Plugin\AmazonPayV2_42\Service\Method\AmazonPay;use Plugin\AmazonPayV2_42\Repository\ConfigRepository;use Symfony\Component\DependencyInjection\ContainerInterface;use Symfony\Component\Form\AbstractTypeExtension;use Symfony\Component\Form\Extension\Core\Type\TextType;use Symfony\Component\Form\Extension\Core\Type\PasswordType;use Symfony\Component\Form\Extension\Core\Type\ChoiceType;use Symfony\Component\Form\Extension\Core\Type\CheckboxType;use Symfony\Component\Form\FormBuilderInterface;use Symfony\Component\Form\FormEvent;use Symfony\Component\Form\FormEvents;use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;class AmazonCustomerExtension extends AbstractTypeExtension{protected $authorizationChecker;protected $paymentRepository;protected $eccubeConfig;protected $configRepository;protected $container;public function __construct(EccubeConfig $eccubeConfig, PaymentRepository $paymentRepository, PluginRepository $pluginRepository, ConfigRepository $configRepository, ContainerInterface $container, AuthorizationCheckerInterface $authorizationChecker){goto TDhY7;TDhY7:$this->paymentRepository = $paymentRepository;goto PBVuu;wsp4n:$this->eccubeConfig = $eccubeConfig;goto fRDAH;G2K7A:$this->container = $container;goto kAWds;kAWds:$this->authorizationChecker = $authorizationChecker;goto wDOqm;crnla:$this->Config = $this->configRepository->get();goto G2K7A;PBVuu:$this->pluginRepository = $pluginRepository;goto wsp4n;fRDAH:$this->configRepository = $configRepository;goto crnla;wDOqm:}public function buildForm(FormBuilderInterface $builder, array $options){goto XKIrc;XKIrc:$self = $this;goto lQbTC;lQbTC:$builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use($self) {goto yUrG7;l4L9U:ALj7S:goto TorIh;HkW48:$form->add('login_check_v2', ChoiceType::class, ['choices' => ['まだ会員登録されていないお客様' => 'regist', '会員登録がお済みのお客様' => 'login'], 'mapped' => false, 'expanded' => true])->add('amazon_login_email_v2', TextType::class, ['mapped' => false, 'required' => false, 'attr' => ['class' => 'form-control', 'max_length' => 50]])->add('amazon_login_password_v2', PasswordType::class, ['mapped' => false, 'required' => false, 'always_empty' => false, 'attr' => ['class' => 'form-control', 'max_length' => 50]]);goto rbA7E;rHCSG:$form = $event->getForm();goto OKfmA;ZEriA:vncB6:goto qX1kO;cXy1H:if (!($this->pluginRepository->findOneBy(['code' => 'MailMagazine42', 'enabled' => true]) || $this->pluginRepository->findOneBy(['code' => 'PostCarrier42', 'enabled' => true]))) {goto vncB6;}goto yQfOC;qX1kO:if (!($this->Config->getLoginRequired() == $this->eccubeConfig['amazon_pay_v2']['toggle']['on'] && !$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY'))) {goto FU9Et;}goto HkW48;k1CsO:$form->add('customer_regist_v2', CheckboxType::class, ['label' => null, 'required' => false, 'mapped' => false, 'attr' => ['autocomplete' => 'off']]);goto cXy1H;yUrG7:$data = $event->getData();goto rHCSG;rbA7E:FU9Et:goto l4L9U;TorIh:UTeAg:goto PP47G;IwMIB:if (!($data->getPayment()->getMethodClass() === AmazonPay::class && !$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY'))) {goto ALj7S;}goto k1CsO;yQfOC:$form->add('mail_magazine', CheckboxType::class, ['label' => null, 'required' => false, 'mapped' => false, 'attr' => ['autocomplete' => 'off']]);goto ZEriA;OKfmA:if (!$data->getPayment()) {goto UTeAg;}goto IwMIB;PP47G:});goto EwUDA;EwUDA:$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {goto dFLWr;lJiPY:$form->remove('customer_regist_v2')->remove('login_check_v2')->remove('amazon_login_email_v2')->remove('amazon_login_password_v2');goto zzl80;zzl80:dcHBj:goto z3l0q;z3l0q:goto sfmw2;goto zgw9j;nRVo7:$Payment = $this->paymentRepository->findOneBy(['method_class' => AmazonPay::class]);goto mvlee;mvlee:$data = $event->getData();goto Wp5G7;TOvMf:if ($options['skip_add_form']) {goto mLIxT;}goto nRVo7;zgw9j:mLIxT:goto PSjgb;hX8Pw:if (!(!empty($data['Payment']) && $Payment->getId() != $data['Payment'])) {goto dcHBj;}goto lJiPY;sjVxw:sfmw2:goto Xft_O;Wp5G7:$form = $event->getForm();goto hX8Pw;PSjgb:return;goto sjVxw;dFLWr:$options = $event->getForm()->getConfig()->getOptions();goto TOvMf;Xft_O:});goto hJyf8;hJyf8:}public function getExtendedType(){return OrderType::class;}public static function getExtendedTypes() : iterable{return [OrderType::class];}}