<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity (repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Column(length: 30)]
    private ?string $immatriculation=null;

    #[ORM\Column(length: 30)]
    private ?string $modele=null;

    #[ORM\Column(length: 30)]
    private ?string $marque=null;

    #[ORM\Column(length: 20)]
    private ?string $etat=null;

    #[ORM\Column(length: 255)]
    private ?string $photo=null;

    #[ORM\ManyToOne (inversedBy: 'Utilisateurs')]
    private ?int $id=null;

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

    public function getId(): ?Utilisateur
    {
        return $this->id;
    }

    public function setId(?Utilisateur $id): self
    {
        $this->id = $id;

        return $this;
    }


}
