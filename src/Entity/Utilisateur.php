<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    #[ORM\Column(length: 100)]
    private ?string $mdp = null;

    #[ORM\Column(length: 20)]
    private ?string $numTel = null;

    #[ORM\Column(length: 30)]
    private ?string $role = null;

    #[ORM\Column]
    private ?float $evaluation=null;
    
    #[ORM\Column]
    private ?bool $bloque = false ;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Reclamation::class, orphanRemoval: true)]
    private Collection $reclamations;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Voiture::class, orphanRemoval: true)]
    private Collection $voitures;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'id1')]
    #[ORM\JoinTable(name: 'commentaire')]
    #[ORM\JoinColumn(name: 'id1 ', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'id2', referencedColumnName: 'id')]
    private $id2 = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEvaluation(): ?float
    {
        return $this->evaluation;
    }

    public function setEvaluation(float $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getId2(): Collection
    {
        return $this->id2;
    }

    public function addId2(Utilisateur $id2): self
    {
        if (!$this->id2->contains($id2)) {
            $this->id2->add($id2);
        }

        return $this;
    }

    public function removeId2(Utilisateur $id2): self
    {
        $this->id2->removeElement($id2);

        return $this;
    }

    public function getBloque(): ?string
    {
        return $this->bloque;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUtilisateur() === $this) {
                $reclamation->setUtilisateur(null);
            }
        }

        return $this;
    }
}
