<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifProfilType extends AbstractType
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
            ->add('numTel', TextType::class, [
                'label' => 'Numéro de téléphone:',
                'attr' => ['placeholder' => 'Saisir votre numéro de téléphone']
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail:',
                'attr' => [
                    'placeholder' => 'saisir votre e-mail'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
