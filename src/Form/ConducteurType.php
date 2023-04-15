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
use Symfony\Component\Validator\Constraints\NotBlank;

class ConducteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('nom', TextType::class, [
                'label' => 'Nom:',
                'constraints' => new NotBlank(message: "Vous devez saisir votre nom"),


                'attr' => [
                    'placeholder' => 'saisir votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom:',
                'constraints' => new NotBlank(message: "Vous devez saisir votre prénom"),
                'attr' => [
                    'placeholder' => 'saisir votre prénom'
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail:',
                'constraints' => new NotBlank(message: "Vous devez saisir votre mail"),
                'attr' => [
                    'placeholder' => 'saisir votre e-mail'
                ]
            ])
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => ' ',
                'first_options' => [
                    'label' => 'Mot de passe:',
                    'constraints' => new NotBlank(message: "Vous devez saisir votre mot de passe"),
                    'attr' => [
                        'placeholder' => 'saisir votre mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe:',
                    'constraints' => new NotBlank(message: "Vous devez saisir votre mot de passe"),
                    'attr' => ['placeholder' => 'Confirmez mot de passe'],
                ]
            ])
            ->add('numTel', TextType::class, [
                'label' => 'Numéro de téléphone:',
                'constraints' => new NotBlank(message: "Vous devez saisir votre numéro"),
                'attr' => ['placeholder' => 'Saisir votre numéro de téléphone']
            ])


            ->add('b3', FileType::class, [
                'label' => 'B3:',
                'constraints' => new NotBlank(message: "Vous devez choisir une image"),
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrer une photo de votre b3'
                ]
            ])

            ->add('permis', FileType::class, [
                'label' => 'Permis:',
                'constraints' => new NotBlank(message: "Vous devez choisir une image"),
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
