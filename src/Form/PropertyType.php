<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            /* or getPropertyChoices() defined on the bottom
            ->add('heat', ChoiceType::class, [
                'choices' => ['Electric' => Property::HEAT[0], 'Gaz' => Property::HEAT[1] ],
            ]) */
            ->add('heat', ChoiceType::class, ['choices' => $this->getPropertyChoices()] )
            /* option entity connected to property entity in the form to select  property bases on options */
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, ['required' => false] )
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold');
            /*->add('created_at') user don't have to change this value on the front end form*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver) { $resolver->setDefaults(['data_class' => Property::class,]); }

    private function getPropertyChoices() 
    {
        $choices = Property::HEAT;
        $output = [];

        foreach($choices as $key => $value) { $output[$value] = $key; }
        return $output;
    }
}
