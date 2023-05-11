<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CourseRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("Course")]
    private ?int $idCourse = null;

    #[ORM\Column(length: 150)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Le champ doit contenir que des lettres.'
    )]
    #[Groups("Course")]
    private ?string $pointDepart = null;

    #[ORM\Column(length: 150)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Le champ doit contenir que des lettres.'
    )]
    #[Groups("Course")]
    private ?string $pointDestination = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ est requis.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    #[Groups("Course")]
    private ?float $distance = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ est requis.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    #[Groups("Course")]
    private  ?float $prix = null;

    

    #[ORM\Column(length: 150)]
    private ?string $statutCourse = null;

    #[ORM\ManyToOne(inversedBy: 'courses', targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'idUser')]
    #[Groups("Course")]
    private ?Utilisateur $user = null;

    


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
    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

  
}

