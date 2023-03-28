<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", uniqueConstraints={@ORM\UniqueConstraint(name="mail", columns={"mail"})})
 * @ORM\Entity
 */
class Utilisateur
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=100, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=100, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="num_tel", type="string", length=20, nullable=false)
     */
    private $numTel;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=false)
     */
    private $role;

    /**
     * @var float
     *
     * @ORM\Column(name="evaluation", type="float", precision=2, scale=1, nullable=false)
     */
    private $evaluation;

    /**
     * @var bool
     *
     * @ORM\Column(name="bloque", type="boolean", nullable=false)
     */
    private $bloque = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="id1")
     * @ORM\JoinTable(name="commentaire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id1", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id2", referencedColumnName="id")
     *   }
     * )
     */
    private $id2 = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id2 = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
