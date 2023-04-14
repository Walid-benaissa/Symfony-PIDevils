<?php

namespace App\Form;
use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('id')
            ->add('idVehicule')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('lieu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }
    
    public function validateDates(Location $location, ExecutionContextInterface $context): void
    {
        $dateDebut = $location->getDateDebut();
        $dateFin = $location->getDateFin();
        $today = new \DateTimeImmutable('today');
        
        if ($dateDebut > $dateFin) {
            $context->buildViolation('La date de fin doit être supérieure ou égale à la date de début.')
                ->atPath('dateFin')
                ->addViolation();
        }
        
        if ($dateDebut < $today || $dateFin < $today) {
            $context->buildViolation('Les dates doivent être supérieures ou égales à la date du jour.')
                ->addViolation();
        }
    }
}