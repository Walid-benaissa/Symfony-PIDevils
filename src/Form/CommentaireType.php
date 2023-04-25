<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class)
            ->add('eval', ChoiceType::class, ['choices'  => [
                '  '=>1,
                ' '=>2,
                '   '=>3,
                '    '=>4,
                '     '=>5,
            ],
            'label'=>false,
                'attr' => ['class' => 'row'],
                'multiple'=>false,
                'expanded'=>true])->getForm()
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
