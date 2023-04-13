<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Vous devez saisir l'immatriculation")]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Vous devez saisir le modèle ")]
    private ?string $modele = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Vous devez saisir la marque ")]
    private ?string $marque = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Vous devez saisir l'etat ")]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Vous devez saisir une photo ")]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'voitures', targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id')]
    private ?Utilisateur $user = null;

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
