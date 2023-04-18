<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Livraison' => 'Livraison',
                    'Course' => 'Course',
                    'Location' => "Location",
                ],
            ])

            /* ->add('user', EntityType::class, [
                "class" => Utilisateur::class,
                'choice_label' => function ($user) {
                    return $user->getId() . "-" . $user->getPrenom() . " " . $user->getNom();
                },
                "multiple" => false,
                "expanded" => false
            ]); */;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
