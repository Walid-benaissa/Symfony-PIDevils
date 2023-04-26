<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;


class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pointDepart', TextType::class, [
                'label' => 'Point de départ',
                'attr' => [
                    'pattern' => '[a-zA-Z ]+',
                    'title' => 'Entrez seulement des lettres et des espaces'
                ]
            ])
            ->add('pointDestination', TextType::class, [
                'label' => 'Point de destination',
                'attr' => [
                    'pattern' => '[a-zA-Z ]+',
                    'title' => 'Entrez seulement des lettres et des espaces'
                ]
            ])
            ->add('distance', NumberType::class, [
                'label' => 'Distance',
                'scale' => 2,
                'attr' => [
                    'step' => 0.01,
                    'min' => 0,
                    'title' => 'Entrez une distance valide'
                ]
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'scale' => 2,
                'attr' => [
                    'step' => 0.01,
                    'min' => 0,
                    'title' => 'Entrez un prix valide'
                ]
            ])
            ->add('statutCourse', ChoiceType::class, [
                'choices' => [
                    'Terminé' => 'Terminé',
                    'En cours' => 'En cours',
                    'En attente' => 'En attente',
                ],
            ])
            ->add('user', EntityType::class, [
                'label' => 'Utilisateur',
                'class' => Utilisateur::class,
                'choice_label' => function ($user) {
                    return $user->getNom().' '.$user->getPrenom();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
