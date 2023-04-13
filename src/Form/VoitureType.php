<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation', TextType::class, [
                'label' => 'Immatriculation:',

                'attr' => [
                    'placeholder' => 'saisir l\'immatriculation de votre voiture'
                ]
            ])
            ->add('modele', TextType::class, [
                'label' => 'Modèle:',

                'attr' => [
                    'placeholder' => 'saisir le Modèle de votre voiture'
                ]
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque:',

                'attr' => [
                    'placeholder' => 'saisir la marque de votre voiture'
                ]
            ])
            ->add('etat', TextType::class, [
                'label' => 'Etat:',

                'attr' => [
                    'placeholder' => 'saisir l\'etat de votre voiture'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image:',
                'required' => false,
                'mapped' => false,


                'attr' => [
                    'placeholder' => 'Entrer une photo de votre voiture'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
