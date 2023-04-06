<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message')
            ->add('etat')
            ->add('user', EntityType::class, [
                "class" => Utilisateur::class,
                'choice_label' => function ($user) {
                    return $user->getId() . "-" . $user->getPrenom() . " " . $user->getNom();
                },
                "multiple" => false,
                "expanded" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
