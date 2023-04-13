<?php

namespace App\Form;

use App\Entity\Conducteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConducteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom:',

                'attr' => [
                    'placeholder' => 'saisir votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom:',
                'attr' => [
                    'placeholder' => 'saisir votre prénom'
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail:',
                'attr' => [
                    'placeholder' => 'saisir votre e-mail'
                ]
            ])
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => ' ',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe:',
                    'attr' => [
                        'placeholder' => 'saisir votre mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe:',
                    'attr' => ['placeholder' => 'Confirmez mot de passe'],
                ]
            ])
            ->add('numTel', TextType::class, [
                'label' => 'Numéro de téléphone:',
                'attr' => ['placeholder' => 'Saisir votre numéro de téléphone']
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Rôle:',
                'choices'  => [
                    'Client' => 'Client',
                    'Conducteur' => 'Conducteur'

                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('b3', FileType::class, [
                'label' => 'Image:',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrer une photo de votre b3'
                ]
            ])
            ->add('permis', FileType::class, [
                'label' => 'Image:',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrer une photo de votre permis'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
