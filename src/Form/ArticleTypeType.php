<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\ArticleType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'delete_label' => '...',
                //'download_label' => 'Télécharger',
                'download_uri' => false,//Pour enkever label download
                //'image_uri' => true,
                'imagine_pattern' => 'squared_thumbnail_small',
                //'asset_helper' => true,
            ])
            ->add('designation', TextType::class)
            ->add('quantity_available')
            ->add('critical_quantity')
            ->add('unit_price')
            ->add('isPromo')
            ->add('typeArticle', EntityType::class, [
                'class' => ArticleType::class,
                'choice_label' => 'name',
                'placeholder' => "Veuillez choisir un type d'article"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
