<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;


#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $idContrat;


    
    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'locations')]
    #[ORM\JoinColumn(name: 'id_vehicule', referencedColumnName: 'id_vehicule')]
    private ?Vehicule $idVehicule = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateDebut = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateFin = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    public function getIdContrat(): ?int
    {
        return $this->idContrat;
    }



    public function getIdVehicule(): ?Vehicule
    {
        return $this->idVehicule;
    }

    public function setIdVehicule(Vehicule $idVehicule): self
    {
        $this->idVehicule = $idVehicule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
}
