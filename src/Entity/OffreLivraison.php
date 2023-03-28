<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreLivraisonRepository;


#[ORM\Entity(repositoryClass: OffreLivraisonRepository::class)]
class OffreLivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(nullable: true)]
    private ?float $prixLivraison = null;

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
