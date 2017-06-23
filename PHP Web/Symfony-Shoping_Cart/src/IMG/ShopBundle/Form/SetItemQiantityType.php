<?php

namespace IMG\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SetItemQiantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity',IntegerType::class,[
            'label' => 'Quantity:'
        ])
            ->add('card_item_id',HiddenType::class)
            ->add('set_quantity', SubmitType::class,[
                'label' => 'Set Quantity'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'imgshop_bundle_set_item_qiantity_type';
    }
}
