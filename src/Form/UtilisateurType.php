<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UtilisateurType extends AbstractType
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
