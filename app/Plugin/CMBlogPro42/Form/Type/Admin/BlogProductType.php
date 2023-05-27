<?php

namespace Plugin\CMBlogPro42\Form\Type\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\Product;
use Eccube\Form\DataTransformer;
use Plugin\CMBlogPro42\Entity\BlogProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogProductType extends AbstractType{

    /**
     * @var EntityManagerInterface 
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $builder->create('Product', HiddenType::class)
                    ->addModelTransformer(new DataTransformer\EntityToIdTransformer($this->entityManager, '\Eccube\Entity\Product'))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogProduct::class
        ]);
    }
} 