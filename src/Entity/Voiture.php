<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureRepository;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Column(length: 30)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 30)]
    private ?string $modele = null;

    #[ORM\Column(length: 30)]
    private ?string $marque = null;

    #[ORM\Column(length: 20)]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'id', targetEntity: Utilisateur::class)]
    private ?int $user = null;

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getuser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setuser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }
}
