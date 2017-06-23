<?php

namespace IMG\ShopBundle\Form;

use IMG\ShopBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name'
            ])
            ->add('description', TextareaType::class,[
                'attr' => [
                    'class' => 'ckeditor'
                    ]
            ])
            ->add('price', MoneyType::class,[
                'currency' => 'BGN',

            ])
            ->add('quantity', NumberType::class)
            ->add('categories',EntityType::class, [
                'class' => 'IMG\ShopBundle\Entity\Category',
                'multiple' => true,

            ])
            ->add('frontImageFile', FileType::class, [
                'data_class' => null,
                'required' => false
            ])
            ->add('expireble', CheckboxType::class,[
                'label' => "Can this item expire ?",
                'required' => false,
            ])
            ->add('expiresAt', DateTimeType::class)
            ->add('add', SubmitType::class, [
                'label' => "Save Item",
                'attr'  => [
                    'class' => 'btn btn-success text-capitalize'
                ]
            ])

        ;
    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMG\ShopBundle\Entity\Item'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'img_shopbundle_item';
    }


}
