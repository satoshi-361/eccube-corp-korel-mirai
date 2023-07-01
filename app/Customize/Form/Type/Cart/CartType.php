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

namespace Customize\Form\Type\Cart;

use Eccube\Common\EccubeConfig;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\AbstractType;
use Eccube\Form\Type\Front\EntryType;
use Customize\Form\Type\Cart\ShippingType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Plugin\EccubePaymentLite42\Form\Type\Front\CreditCardForTokenPaymentType;

class CartType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * ShippingType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        EccubeConfig $eccubeConfig
    ) {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntryType::class, [
                'required' => true,
                'flag_member' => $options['flag_member'],
            ])
            ->add('is_member', ChoiceType::class, [
                'choices' => [
                    '登録する' => 1,
                    '登録しない' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('shipping_address', ChoiceType::class, [
                'choices' => [
                    '登録の住所に届ける' => 0,
                    '登録以外の住所に届ける' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('shipping', ShippingType::class, [
                'required' => true,
            ])
            ->add('privacy_check', CheckboxType::class, [
                'required' => true,
                'label' => 'プライバシーポリシーに同意する',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('credit', CreditCardForTokenPaymentType::class, [
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'flag_member' => false,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cart';
    }
}
