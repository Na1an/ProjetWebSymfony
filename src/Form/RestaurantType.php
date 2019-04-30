<?php
namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('telephone')
            ->add('start_at')
            ->add('close_at')
            ->add('average_price')
            ->add('transportation')
            ->add('place')
            ->add('options',EntityType::class,[
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('evaluation', ChoiceType::class, [
                'choices' => $this->getEvaChoice()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }

    private function getEvaChoice()
    {
        $choices = Restaurant::EVALUATION;
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
