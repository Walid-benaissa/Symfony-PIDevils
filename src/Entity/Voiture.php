<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture", indexes={@ORM\Index(name="fk_utilisateur_voiture", columns={"id"})})
 * @ORM\Entity
 */
class Voiture
{
    /**
     * @var string
     *
     * @ORM\Column(name="immatriculation", type="string", length=30, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $immatriculation;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=30, nullable=false)
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=30, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;


}
