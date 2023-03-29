<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $message = null;

    #[ORM\Column(length: 150)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations', targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'idUser')]
    private ?Utilisateur $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getadmin(): ?Utilisateur
    {
        return $this->admin;
    }

    public function setadmin(?Utilisateur $admin): self
    {
        $this->admin = $admin;

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
}
