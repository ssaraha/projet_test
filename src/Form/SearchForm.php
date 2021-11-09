<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Data\SearchData;
use App\Entity\ArticleType;

class SearchForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('q', TextType::class,
    					[
    						'required' => false, 
    						'label' => false,
    						'attr' => [
    								  	'placeholder' => 'Rechercher un produit'
    								  ]
    					] 
    				)
    			->add('min_price', NumberType::class,
    					[
    						'required' => false,
    						'label' => false,
    						'attr' => [
    								  	'placeholder' => 'Prix minimum'
    								  ]
    					]
    				)
    			->add('max_price', NumberType::class,
    					[
    						'required' => false,
    						'label' => false,
    						'attr' => [
    								  	'placeholder' => 'Prix maximum'
    								  ]
    					]
    				)
    			->add('categories', EntityType::class, 
    					[
    						'required' => false,
    						'label' => false,
    						'class' => ArticleType::class,
    						'expanded' => true,
    						'multiple' => true
    					])
                ->add('promo', CheckboxType::class, 
                        [
                            'label' => 'En promotion',
                            'required' => false,
                        ]
                    )
		;
    }

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csfr_protection' => false
        ]);
    }

    public function setBlockPrefix()
    {

    	return ''; //Eviter le prefix sur le nom des objets du formulaire
    }
}