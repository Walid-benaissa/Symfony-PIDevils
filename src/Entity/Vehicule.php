<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule", indexes={@ORM\Index(name="fk_u_v", columns={"id"}), @ORM\Index(name="fk_vehicule_promotion", columns={"id_promotion"})})
 * @ORM\Entity
 */
class Vehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vehicule", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVehicule;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_v", type="string", length=255, nullable=false)
     */
    private $nomV;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=false)
     */
    private $ville;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="disponibilite", type="boolean", nullable=true)
     */
    private $disponibilite;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \Promotion
     *
     * @ORM\ManyToOne(targetEntity="Promotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_promotion", referencedColumnName="id_promotion")
     * })
     */
    private $idPromotion;


}
