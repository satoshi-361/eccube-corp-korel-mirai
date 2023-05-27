<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Controller\Admin;use Eccube\Controller\AbstractController;use Plugin\AmazonPayV2_42\Form\Type\Admin\ConfigType;use Plugin\AmazonPayV2_42\Repository\ConfigRepository;use Symfony\Component\Form\FormError;use Symfony\Component\Routing\Annotation\Route;use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;use Symfony\Component\HttpFoundation\Request;use Symfony\Component\Validator\Constraints as Assert;use Symfony\Component\Validator\Validator\ValidatorInterface;class ConfigController extends AbstractController{protected $validator;protected $configRepository;public function __construct(ValidatorInterface $validator, ConfigRepository $configRepository){$this->validator = $validator;$this->configRepository = $configRepository;}    /**
     * @Route("/%eccube_admin_route%/amazon_pay_v2_42/config", name="amazon_pay_v2.42_admin_config")
     * @Template("@AmazonPayV2_42/admin/config.twig")
     */
public function index(Request $request){goto pBBEx;LyIQb:if (!is_file($privateKeyPath) || file_exists($privateKeyPath) === false) {goto N6S0z;}goto qFNTp;qFNTp:goto XvxA0;goto zrlip;WXrQZ:$form->handleRequest($request);goto hnVbH;VEuhj:$privateKeyPath = $this->getParameter('kernel.project_dir') . '/' . $Config->getPrivateKeyPath();goto EWJXf;qsPBG:N6S0z:goto GO47M;zrlip:ya5x3:goto vIyGB;BCKh0:return ['form' => $form->createView(), 'testAccount' => $testAccount];goto KC9rF;FNSsb:dT8Am:goto tffXS;ptmvG:$this->entityManager->flush($Config);goto RSWdq;CVaYA:XvxA0:goto tVu4T;SXbKZ:goto XvxA0;goto qsPBG;akxRV:dmsj9:goto btmOC;mUhFn:if ($errors->count() != 0) {goto crLHb;}goto LYT2w;kRzVM:IgiTZ:goto FNSsb;aJqNG:if (!($Config->getEnv() == $this->eccubeConfig['amazon_pay_v2']['env']['prod'])) {goto dT8Am;}goto YWn76;bonwc:$this->entityManager->persist($Config);goto ptmvG;g1h6o:$form['prod_key']->addError(new FormError('本番切り替えキーは有効なキーではありません。'));goto uO99I;YWn76:$prod_key = $Config->getProdKey();goto uFLzr;MQLsV:if (!($form->isSubmitted() && $form->isValid())) {goto r9RHV;}goto bonwc;vIyGB:$form['private_key_path']->addError(new FormError('プライベートキーパスの先頭に"/"は利用できません'));goto SXbKZ;hnVbH:if (!($form->isSubmitted() && $form->isValid())) {goto EHHRT;}goto RD4CW;i238H:crLHb:goto pbJ3Y;iuMML:return $this->redirectToRoute('amazon_pay_v2.42_admin_config');goto I6c9k;RD4CW:$Config = $form->getData();goto aJqNG;pbJ3Y:foreach ($errors as $error) {$messages[] = $error->getMessage();Q7Gkh:}goto akxRV;tffXS:if (!($Config->getAmazonAccountMode() == $this->eccubeConfig['amazon_pay_v2']['account_mode']['owned'])) {goto a2ygg;}goto VEuhj;WWrZC:$testAccount = $this->eccubeConfig['amazon_pay_v2']['test_account'];goto BCKh0;WM02M:$form = $this->createForm(ConfigType::class, $Config);goto WXrQZ;uO99I:R5HZt:goto HJ1tD;I6c9k:r9RHV:goto RLyDb;tVu4T:a2ygg:goto MQLsV;EWJXf:if (mb_substr($Config->getPrivateKeyPath(), 0, 1) == '/') {goto ya5x3;}goto LyIQb;RLyDb:EHHRT:goto WWrZC;RSWdq:$this->addSuccess('amazon_pay_v2.admin.save.success', 'admin');goto iuMML;pBBEx:$Config = $this->configRepository->get(true);goto WM02M;btmOC:$form['prod_key']->addError(new FormError($messages[0]));goto kRzVM;LYT2w:if (password_verify($prod_key, '$2y$10$m3aYrihBaIKarlrmI39tGORK4fFBC7cWoSLFy6jkMpT7IduYVsVtO')) {goto R5HZt;}goto g1h6o;uFLzr:$errors = $this->validator->validate($prod_key, [new Assert\NotBlank()]);goto mUhFn;HJ1tD:goto IgiTZ;goto i238H;GO47M:$form['private_key_path']->addError(new FormError('プライベートキーファイルが見つかりません。'));goto CVaYA;KC9rF:}}