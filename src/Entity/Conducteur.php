<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conducteur
 *
 * @ORM\Table(name="conducteur", indexes={@ORM\Index(name="fk_utilisateur_conducteur", columns={"id"})})
 * @ORM\Entity
 */
class Conducteur
{
    /**
     * @var string
     *
     * @ORM\Column(name="b3", type="string", length=255, nullable=false)
     */
    private $b3;

    /**
     * @var string
     *
     * @ORM\Column(name="permis", type="string", length=255, nullable=false)
     */
    private $permis;

    /**
     * @var \Utilisateur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;


}
