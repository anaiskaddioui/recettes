<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                "label" => "Titre"
            ])
            ->add('type', EntityType::class, [
                "label" => "Choix de catégorie",
                "class" => Type::class,
                "choice_label" => "nom"
            ])
            ->add('description')
            ->add('preparation')
            ->add('time', null, [
                "label" => "Temps de préparation"
            ])
            ->add('personnes')
            ->add('images', FileType::class, [
                'label' => 'Image(s)',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class
        ]);
    }
}
