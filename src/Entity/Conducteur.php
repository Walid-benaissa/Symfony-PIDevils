<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conducteur
 *
 * @ORM\Table(name="conducteur", indexes={@ORM\Index(name="fk_utilisateur_conducteur", columns={"id"})})
 * @ORM\Entity
 */
class Conducteur
{
    /**
     * @var string
     *
     * @ORM\Column(name="b3", type="string", length=255, nullable=false)
     */
    private $b3;

    /**
     * @var string
     *
     * @ORM\Column(name="permis", type="string", length=255, nullable=false)
     */
    private $permis;

    /**
     * @var \Utilisateur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

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
        return $this->id;
    }

    public function setId(?Utilisateur $id): self
    {
        $this->id = $id;

        return $this;
    }


}
