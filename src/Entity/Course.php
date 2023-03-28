<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity
 */
class Course
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_course", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCourse;

    /**
     * @var string
     *
     * @ORM\Column(name="point_depart", type="string", length=255, nullable=false)
     */
    private $pointDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="point_destination", type="string", length=255, nullable=false)
     */
    private $pointDestination;

    /**
     * @var float
     *
     * @ORM\Column(name="distance", type="float", precision=10, scale=0, nullable=false)
     */
    private $distance;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_course", type="string", length=255, nullable=false)
     */
    private $statutCourse;


}
