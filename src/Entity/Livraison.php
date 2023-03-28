<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_livraison_client", columns={"id_client"}), @ORM\Index(name="fk_livraison_conducteur", columns={"id_livreur"}), @ORM\Index(name="fk_livraison_colis", columns={"id_colis"})})
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_livraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_expedition", type="string", length=30, nullable=false)
     */
    private $adresseExpedition;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_destinataire", type="string", length=30, nullable=false)
     */
    private $adresseDestinataire;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=30, nullable=false)
     */
    private $etat;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var \Colis
     *
     * @ORM\ManyToOne(targetEntity="Colis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_colis", referencedColumnName="id")
     * })
     */
    private $idColis;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_livreur", referencedColumnName="id")
     * })
     */
    private $idLivreur;

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
        return $this->idClient;
    }

    public function setIdClient(?Utilisateur $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdColis(): ?Colis
    {
        return $this->idColis;
    }

    public function setIdColis(?Colis $idColis): self
    {
        $this->idColis = $idColis;

        return $this;
    }

    public function getIdLivreur(): ?Utilisateur
    {
        return $this->idLivreur;
    }

    public function setIdLivreur(?Utilisateur $idLivreur): self
    {
        $this->idLivreur = $idLivreur;

        return $this;
    }


}
