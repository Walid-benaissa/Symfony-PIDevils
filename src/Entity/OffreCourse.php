<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OffreCourse
 *
 * @ORM\Table(name="offre_course")
 * @ORM\Entity
 */
class OffreCourse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule_vehicule", type="integer", nullable=false)
     */
    private $matriculeVehicule;

    /**
     * @var int
     *
     * @ORM\Column(name="cin_conducteur", type="integer", nullable=false)
     */
    private $cinConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_passagers", type="integer", nullable=false)
     */
    private $nbPassagers;

    /**
     * @var string
     *
     * @ORM\Column(name="options_offre", type="string", length=255, nullable=false)
     */
    private $optionsOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_offre", type="string", length=255, nullable=false)
     */
    private $statutOffre;


}
