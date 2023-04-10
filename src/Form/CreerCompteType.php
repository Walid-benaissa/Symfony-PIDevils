<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom:'])
            ->add('prenom', TextType::class, ['label' => 'Prénom:'])
            ->add('mail', TextType::class, ['label' => 'E-mail:'])
            ->add('mdp', PasswordType::class, ['label' => 'Mot de passe:'])
            ->add('mdpc', PasswordType::class, ['label' => 'Confirmer mot de passe:'])
            ->add('numTel', TextType::class, ['label' => 'Numero de téléphone:'])
            ->add('role', TextType::class, ['label' => 'Rôle:']);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
