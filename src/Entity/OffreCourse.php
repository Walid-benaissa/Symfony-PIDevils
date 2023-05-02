<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreCourseRepository;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: OffreCourseRepository::class)]
class OffreCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $idOffre;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le champ est requis.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'Le champ doit contenir que des nombres.'
    )]
    private ?int $matriculeVehicule = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le champ est requis.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'Le champ doit contenir que des nombres.'
    )]
    private ?int $cinConducteur = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le champ est requis.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'Le champ doit contenir que des nombres.'
    )]
    private ?int $nbPassagers = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $optionsOffre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private $statutOffre;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getMatriculeVehicule(): ?int
    {
        return $this->matriculeVehicule;
    }

    public function setMatriculeVehicule(int $matriculeVehicule): self
    {
        $this->matriculeVehicule = $matriculeVehicule;

        return $this;
    }

    public function getCinConducteur(): ?int
    {
        return $this->cinConducteur;
    }

    public function setCinConducteur(int $cinConducteur): self
    {
        $this->cinConducteur = $cinConducteur;

        return $this;
    }

    public function getNbPassagers(): ?int
    {
        return $this->nbPassagers;
    }

    public function setNbPassagers(int $nbPassagers): self
    {
        $this->nbPassagers = $nbPassagers;

        return $this;
    }

    public function getOptionsOffre(): ?string
    {
        return $this->optionsOffre;
    }

    public function setOptionsOffre(string $optionsOffre): self
    {
        $this->optionsOffre = $optionsOffre;

        return $this;
    }

    public function getStatutOffre(): ?string
    {
        return $this->statutOffre;
    }

    public function setStatutOffre(string $statutOffre): self
    {
        $this->statutOffre = $statutOffre;

        return $this;
    }
}
