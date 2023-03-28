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

    public function getIdCourse(): ?int
    {
        return $this->idCourse;
    }

    public function getPointDepart(): ?string
    {
        return $this->pointDepart;
    }

    public function setPointDepart(string $pointDepart): self
    {
        $this->pointDepart = $pointDepart;

        return $this;
    }

    public function getPointDestination(): ?string
    {
        return $this->pointDestination;
    }

    public function setPointDestination(string $pointDestination): self
    {
        $this->pointDestination = $pointDestination;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStatutCourse(): ?string
    {
        return $this->statutCourse;
    }

    public function setStatutCourse(string $statutCourse): self
    {
        $this->statutCourse = $statutCourse;

        return $this;
    }


}
