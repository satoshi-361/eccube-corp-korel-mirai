<?php

namespace Plugin\CMBlogPro42\Form\Type\Admin;

use Plugin\CMBlogPro42\Entity\Config;
use Plugin\CMBlogPro42\Entity\BlogSort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Plugin\CMBlogPro42\Repository\BlogSortRepository;

class ConfigType extends AbstractType
{

    /**
    * @var BlogSortRepository
    */
   protected $blogSortRepository;

   /**
    * ProductType constructor.
    *
    * @param BlogSortRepository $blogSortRepository
    */
    public function __construct(
        BlogSortRepository $blogSortRepository
    ) {
        $this->blogSortRepository = $blogSortRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('display_block', IntegerType::class)
            ->add('display_page', IntegerType::class)
            ->add('title_en', TextType::class, [
                'attr' => [
                    'placeholder' => 'plg.CMBlogPro.admin.config.title_en'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('title_jp', TextType::class, [
                'attr' => [
                    'placeholder' => 'plg.CMBlogPro.admin.config.title_jp'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('Sort', ChoiceType::class, [
                'placeholder' => '選択してください',
                'choice_label' => 'Name',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'mapped' => false,
                'choices' => $this->blogSortRepository->getList(),
                'choice_value' => function (BlogSort $BlogSort = null) {
                    return $BlogSort ? $BlogSort->getId() : null;
                },
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
