<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehiculeRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idVehicule = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'le nom ne peut  pas contenir des chiffres',
    )]
    private ?string $nomV = null;


    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
   
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    private ?string $ville = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    private ?float $prix = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ est obligatoire")]
    private ?string $type = null;

    //#[ORM\ManyToOne(inversedBy: 'idPromotion', targetEntity: Promotion::class)]
    //private ?Promotion $Promotion = null;

    public function getIdVehicule(): ?int
    {
        return $this->idVehicule;
    }

    public function getNomV(): ?string
    {
        return $this->nomV;
    }

    public function setNomV(string $nomV): self
    {
        $this->nomV = $nomV;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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



    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /* public function getPromotion(): ?Promotion
    {
        return $this->Promotion;
    }

    public function setPromotion(?Promotion $Promotion): self
    {
        $this->Promotion = $Promotion;

        return $this;
    } */
}