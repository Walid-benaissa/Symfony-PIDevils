<?php

namespace App\Form;

use App\Entity\OffreCourse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class OffreCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('matriculeVehicule', NumberType::class, [
            'constraints' => [
                new Assert\NotBlank(),
               
            ],
        ])
        ->add('cinConducteur', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex(['pattern' => '/^\d{8}$/']),
            ],
        ])
        ->add('nbPassagers', NumberType::class, [
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ])
        ->add('optionsOffre', ChoiceType::class, [
            'choices' => [
                'Economic' => 'economic',
                'Comfort' => 'comfort',
                'Premuim' => 'premuim',
            ],
        ])
        ->add('statutOffre', ChoiceType::class, [
            'choices' => [
                'Actif' => 'actif',
                'Inactif' => 'inactif',
               
            ],
        ]);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffreCourse::class,
        ]);
    }
}
