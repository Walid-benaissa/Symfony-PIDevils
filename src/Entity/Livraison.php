<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $idLivraison = null;

    #[ORM\Column(length: 150)]
    private ?string $adresseExpedition = null;

    #[ORM\Column(length: 150)]
    private ?string $adresseDestinataire = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 150)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'Livraison')]
    private ?Utilisateur $Client = null;

    #[ORM\ManyToOne(inversedBy: 'Livraison')]
    private ?Colis $Colis = null;

    #[ORM\ManyToOne(inversedBy: 'Livraison')]
    private ?Utilisateur $Livreur = null;

    public function getIdLivraison(): ?int
    {
        return $this->idLivraison;
    }

    public function getAdresseExpedition(): ?string
    {
        return $this->adresseExpedition;
    }

    public function setAdresseExpedition(string $adresseExpedition): self
    {
        $this->adresseExpedition = $adresseExpedition;

        return $this;
    }

    public function getAdresseDestinataire(): ?string
    {
        return $this->adresseDestinataire;
    }

    public function setAdresseDestinataire(string $adresseDestinataire): self
    {
        $this->adresseDestinataire = $adresseDestinataire;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdClient(): ?Utilisateur
    {
        return $this->Client;
    }

    public function setIdClient(?Utilisateur $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getIdColis(): ?Colis
    {
        return $this->Colis;
    }

    public function setIdColis(?Colis $Colis): self
    {
        $this->Colis = $Colis;

        return $this;
    }

    public function getIdLivreur(): ?Utilisateur
    {
        return $this->Livreur;
    }

    public function setIdLivreur(?Utilisateur $Livreur): self
    {
        $this->Livreur = $Livreur;

        return $this;
    }
}
