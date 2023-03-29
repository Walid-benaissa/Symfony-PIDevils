<?php

namespace App\Entity;

use App\Repository\ConducteurRepository;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConducteurRepository::class)]

class Conducteur
{
    #[ORM\Column(length: 150)]
    private ?string $b3 = null;

    #[ORM\Column(length: 150)]
    private ?string $permis = null;

    #[ORM\OneToOne(inversedBy: 'id', targetEntity: Utilisateur::class)]
    private ?Utilisateur $utilisateur = null;

    public function getB3(): ?string
    {
        return $this->b3;
    }

    public function setB3(string $b3): self
    {
        $this->b3 = $b3;

        return $this;
    }

    public function getPermis(): ?string
    {
        return $this->permis;
    }

    public function setPermis(string $permis): self
    {
        $this->permis = $permis;

        return $this;
    }

    public function getId(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setId(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
