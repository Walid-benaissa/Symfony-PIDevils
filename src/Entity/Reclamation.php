<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;

#[ORM\Entity (repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id=null ;

    #[ORM\Column(length: 150)]
    private ?string $message=null ;

    #[ORM\Column(length: 150)]
    private ?string $etat=null;

    #[ORM\ManyToOne (inversedBy: 'Utilisateurs')]
    private ?int $idadmin=null ;

    #[ORM\ManyToOne (inversedBy: 'Utilisateurs')]
    private ?int $iduser=null ;

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

    public function getIdadmin(): ?Utilisateur
    {
        return $this->idadmin;
    }

    public function setIdadmin(?Utilisateur $idadmin): self
    {
        $this->idadmin = $idadmin;

        return $this;
    }

    public function getIduser(): ?Utilisateur
    {
        return $this->iduser;
    }

    public function setIduser(?Utilisateur $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
