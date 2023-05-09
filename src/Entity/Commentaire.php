<?php

namespace App\Entity;

use App\Validator as AcmeAssert;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("commentaire")]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("commentaire")]
    private ?Utilisateur $id1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("commentaire")]
    private ?Utilisateur $id2 = null;

    #[ORM\Column(length: 255)]
    #[AcmeAssert\ContainsMotCensor]
    #[Assert\NotBlank(message: "Vous devez saisir un message ")]
    #[Groups("commentaire")]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getId1(): ?Utilisateur
    {
        return $this->id1;
    }

    public function setId1(?Utilisateur $id1): self
    {
        $this->id1 = $id1;

        return $this;
    }

    public function getId2(): ?Utilisateur
    {
        return $this->id2;
    }

    public function setId2(?Utilisateur $id2): self
    {
        $this->id2 = $id2;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
