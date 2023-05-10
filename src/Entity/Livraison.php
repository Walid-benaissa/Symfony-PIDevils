<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", name: "id_livraison", nullable: false)]
    #[Groups("livraison")]
    private int $idLivraison;

    #[ORM\Column(length: 150)]
    #[Groups("livraison")]
    #[Assert\NotBlank(message: "L'adresse d'expédition est obligatoire !")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s]+$/',
        message: "L'adresse d'expédition ne doit pas contenir des caractères spéciaux !"
    )]
    private ?string $adresseExpedition = null;

    #[ORM\Column(length: 150)]
    #[Groups("livraison")]
    #[Assert\NotBlank(message: "L'adresse destinataire est obligatoire !")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s]+$/',
        message: "L'adresse destinataire ne doit pas contenir des caractères spéciaux !"
    )]
    private ?string $adresseDestinataire = null;

    #[ORM\Column]
    #[Groups("livraison")]
    #[Assert\NotBlank(message: "Le prix est obligatoire !")]
    #[Assert\NotEqualTo(value: 0, message: "Le prix ne doit pas être égal à 0 !")]
    #[Assert\Positive(message: "Le prix ne doit pas être négatif !")]
    private ?float $prix = null;

    #[ORM\Column(length: 150)]
    #[Groups("livraison")]
    private ?string $etat = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_client')]
    private ?Utilisateur $Client = null;

    #[ORM\OneToOne(targetEntity: Colis::class)]
    #[ORM\JoinColumn(name: 'id_colis')]
    private ?Colis $Colis = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_livreur')]
    private ?Utilisateur $Livreur = null;

    public function getIdLivraison(): int
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

    public function getClient(): ?Utilisateur
    {
        return $this->Client;
    }

    public function setClient(?Utilisateur $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getColis(): ?Colis
    {
        return $this->Colis;
    }

    public function setColis(?Colis $Colis): self
    {
        $this->Colis = $Colis;

        return $this;
    }

    public function getLivreur(): ?Utilisateur
    {
        return $this->Livreur;
    }

    public function setLivreur(?Utilisateur $Livreur): self
    {
        $this->Livreur = $Livreur;

        return $this;
    }
}
