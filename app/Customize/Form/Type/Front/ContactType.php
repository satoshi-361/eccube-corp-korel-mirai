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

namespace Customize\Form\Type\Front;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Type\PhoneNumberType;
use Eccube\Form\Validator\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Eccube\Form\Type\Front\ContactType as BaseType;

class ContactType extends BaseType
{
    public function __construct(EccubeConfig $eccubeConfig)
    {
        parent::__construct( $eccubeConfig );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('phone_number', PhoneNumberType::class, [
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Email(null, null, $this->eccubeConfig['eccube_rfc_email_check'] ? 'strict' : null),
                ],
            ])
            ->add('query', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '商品について' => '商品について',
                    '当ショップについ' => '当ショップについ',
                    'その他' => 'その他',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('contents', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_lltext_len'],
                    ])
                ],
            ])
            ->add('privacy_check', CheckboxType::class, [
                'required' => true,
                'label' => null,
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
    }
}
