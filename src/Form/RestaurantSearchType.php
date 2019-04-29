<?php

namespace App\Form;

use APP\Entity\RestaurantSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RestaurantSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'Price max'
                ]
            ] )
            ->add('minPlace', IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'Place min'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RestaurantSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
