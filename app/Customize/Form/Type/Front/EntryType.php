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
use Eccube\Entity\Customer;
use Eccube\Form\Type\AddressType;
use Eccube\Form\Type\KanaType;
use Eccube\Form\Type\Master\JobType;
use Eccube\Form\Type\Master\SexType;
use Eccube\Form\Type\NameType;
use Eccube\Form\Type\PhoneNumberType;
use Eccube\Form\Type\PostalType;
use Eccube\Form\Type\RepeatedPasswordType;
use Eccube\Form\Type\RepeatedEmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Eccube\Form\Type\Front\EntryType as BaseType;

class EntryType extends BaseType
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
            ->add('name', NameType::class, [
                'required' => true,
            ])
            ->add('kana', KanaType::class, [
                'required' => true,
            ])
            ->add('postal_code', PostalType::class)
            ->add('address', AddressType::class)
            ->add('phone_number', PhoneNumberType::class, [
                'required' => true,
            ])
            ->add('email', RepeatedEmailType::class)
            ->add('plain_password', RepeatedPasswordType::class)
            ->add('job', JobType::class, [
                'required' => false,
            ]);

            if ( $options['flag_member'] ) {
                // 会員登録の場合
                $builder
                ->add('birth', BirthdayType::class, [
                    'required' => true,
                    'input' => 'datetime',
                    'years' => range(date('Y'), date('Y') - $this->eccubeConfig['eccube_birth_max']),
                    'widget' => 'choice',
                    'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
                    'constraints' => [
                        new Assert\LessThanOrEqual([
                            'value' => date('Y-m-d', strtotime('-1 day')),
                            'message' => 'form_error.select_is_future_or_now_date',
                        ]),
                        new Assert\NotBlank(),
                    ],
                ])
                ->add('sex', SexType::class, [
                    'required' => true,
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]);
            } else {
                // 会員登録をしていない場合
                $builder
                ->add('birth', BirthdayType::class, [
                    'required' => false,
                    'input' => 'datetime',
                    'years' => range(date('Y'), date('Y') - $this->eccubeConfig['eccube_birth_max']),
                    'widget' => 'choice',
                    'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
                    'constraints' => [
                        new Assert\LessThanOrEqual([
                            'value' => date('Y-m-d', strtotime('-1 day')),
                            'message' => 'form_error.select_is_future_or_now_date',
                        ]),
                    ],
                ])
                ->add('sex', SexType::class, [
                    'required' => false,
                ]);
            }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $Customer = $event->getData();
            if ($Customer instanceof Customer && !$Customer->getId()) {
                $form = $event->getForm();

                $form->add('privacy_check', CheckboxType::class, [
                    'required' => true,
                    'label' => null,
                    'mapped' => false,
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]);
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var Customer $Customer */
            $Customer = $event->getData();
            if ($Customer->getPlainPassword() != '' && $Customer->getPlainPassword() == $Customer->getEmail()) {
                $form['plain_password']['first']->addError(new FormError(trans('common.password_eq_email')));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Eccube\Entity\Customer',
            'flag_member' => true,
        ]);
    }
}
