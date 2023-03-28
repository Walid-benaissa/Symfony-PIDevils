<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OffreLivraison
 *
 * @ORM\Table(name="offre_livraison")
 * @ORM\Entity
 */
class OffreLivraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_livraison", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixLivraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixLivraison(): ?float
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison(float $prixLivraison): self
    {
        $this->prixLivraison = $prixLivraison;

        return $this;
    }


}
