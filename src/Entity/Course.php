<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CourseRepository;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCourse = null;

    #[ORM\Column(length: 150)]
    private ?string $pointDepart = null;

    #[ORM\Column(length: 150)]
    private ?string $pointDestination = null;

    #[ORM\Column]
    private ?float $distance = null;

    #[ORM\Column]
    private  ?float $prix = null;

    #[ORM\Column(length: 150)]
    private ?string $statutCourse = null;

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
