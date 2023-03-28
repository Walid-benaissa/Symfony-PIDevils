<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colis
 *
 * @ORM\Table(name="colis")
 * @ORM\Entity
 */
class Colis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_items", type="integer", nullable=false)
     */
    private $nbItems;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="poids", type="float", precision=10, scale=0, nullable=false)
     */
    private $poids;


}
