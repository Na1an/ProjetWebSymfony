<?php
namespace App\Form;

use App\Entity\Option;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('telephone')
            ->add('start_at',DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('close_at',DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
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
                'choices' => $this->getEvaChoice(),
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
        $res = [];
        foreach($choices as $k => $v) {
            $res[$v] = $k;
        }
        return $res;
    }
}
