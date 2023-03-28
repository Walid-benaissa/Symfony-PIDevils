<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OffreCourse
 *
 * @ORM\Table(name="offre_course")
 * @ORM\Entity
 */
class OffreCourse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule_vehicule", type="integer", nullable=false)
     */
    private $matriculeVehicule;

    /**
     * @var int
     *
     * @ORM\Column(name="cin_conducteur", type="integer", nullable=false)
     */
    private $cinConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_passagers", type="integer", nullable=false)
     */
    private $nbPassagers;

    /**
     * @var string
     *
     * @ORM\Column(name="options_offre", type="string", length=255, nullable=false)
     */
    private $optionsOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_offre", type="string", length=255, nullable=false)
     */
    private $statutOffre;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getMatriculeVehicule(): ?int
    {
        return $this->matriculeVehicule;
    }

    public function setMatriculeVehicule(int $matriculeVehicule): self
    {
        $this->matriculeVehicule = $matriculeVehicule;

        return $this;
    }

    public function getCinConducteur(): ?int
    {
        return $this->cinConducteur;
    }

    public function setCinConducteur(int $cinConducteur): self
    {
        $this->cinConducteur = $cinConducteur;

        return $this;
    }

    public function getNbPassagers(): ?int
    {
        return $this->nbPassagers;
    }

    public function setNbPassagers(int $nbPassagers): self
    {
        $this->nbPassagers = $nbPassagers;

        return $this;
    }

    public function getOptionsOffre(): ?string
    {
        return $this->optionsOffre;
    }

    public function setOptionsOffre(string $optionsOffre): self
    {
        $this->optionsOffre = $optionsOffre;

        return $this;
    }

    public function getStatutOffre(): ?string
    {
        return $this->statutOffre;
    }

    public function setStatutOffre(string $statutOffre): self
    {
        $this->statutOffre = $statutOffre;

        return $this;
    }


}
