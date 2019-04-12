<?php
// Form use to search property by criteria
namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minSurface', IntegerType::class, [
                    'required' =>   false,
                    'label' =>   false,
                    'attr' =>   ['placeholder' => 'Surface minimale']
                ])
            ->add('maxPrice', IntegerType::class, [
                    'required' =>   false,
                    'label' =>   false,
                    'attr' =>   ['placeholder' => 'Budget max']
                ])
            
            //->add('minPrice')
        ;
    }

    /**
     * get method added because we dont want to persist the form data
     * desactivate the csrf_protection because no token neeeded to search an property 
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' =>     'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
