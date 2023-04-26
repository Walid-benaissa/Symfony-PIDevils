<?php

namespace App\Entity;

use App\Repository\ColisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ColisRepository::class)]

class Colis
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Nombre d'objets obligatoire !")]
    private ?int $nbItems = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Description est obligatoire !")]
    #[
        Assert\Length(
            min: 5,
            max: 39,
            minMessage: "La description doit comporter au moins 5 caractères ! ",
            maxMessage: "La description doit comporter au plus 5 caractères ! ",
        )
    ]


    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Poids obligatoire !")]
    #[Assert\Type(type: "float", message: "Le prix doit être de type float.")]

    private ?float $poids = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbItems(): ?int
    {
        return $this->nbItems;
    }

    public function setNbItems(int $nbItems): self
    {
        $this->nbItems = $nbItems;

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

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }
}
