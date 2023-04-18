<?php

namespace App\Form;

use App\Entity\Colis;
use App\Entity\Livraison;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseExpedition')
            ->add('adresseDestinataire')
            ->add('prix')
            // ->add('etat')
            ->add('colis', EntityType::class, [
                "class" => Colis::class,
                'choice_label' => 'description',
                "multiple" => false,
                "expanded" => false
            ]);
        // ->add('colis', EntityType::class, [
        //     "class" => Colis::class,
        //     'choice_label' => 'description',
        //     "multiple" => false,
        //     "expanded" => false,
        //     "query_builder" => function (EntityRepository $er) {
        //         return $er->createQueryBuilder('c')
        //             ->leftJoin('c.livraison', 'l')
        //             ->where('l.id IS NULL');
        //     }
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
