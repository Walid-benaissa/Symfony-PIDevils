<?php

namespace App\Repository;

use App\Entity\Livraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livraison>
 *
 * @method Livraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livraison[]    findAll()
 * @method Livraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livraison::class);
    }

    public function save(Livraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function remove(Livraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByOffre()
    {
        return $this->createQueryBuilder('l')
            ->where('l.Livreur IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function findByUser($id)
    {
        return $this->createQueryBuilder('l')
            ->join('l.Client', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function findBylivreur($id)
    {
        return $this->createQueryBuilder('l')
            ->join('l.Livreur', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Livraison[] Returns an array of Livraison objects
    //     */
    // public function findLivraisonByPrixInterval($prixMin, $prixMax)
    // {
    //     return $this->createQueryBuilder('l')
    //         ->andWhere('l.prix >= :prixMin and l.prix <= :prixMax')
    //         ->setParameters(['prixMin' => $prixMin, 'prixMax' => $prixMax])
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findByPrix($minPrix, $maxPrix)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prix >= :minPrix')
            ->setParameter('minPrix', $minPrix)
            ->andWhere('p.prix <= :maxPrix')
            ->setParameter('maxPrix', $maxPrix)
            ->getQuery()
            ->getResult();
    }



    public function rechercheParetat($etat, $adresseDestinataire)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('1 = 1');

        if (!empty($etat)) {
            $qb->andWhere('p.etat LIKE :etat')
                ->setParameter('etat', '%' . $etat . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function sortByprix()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function sortByadresse()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nomV', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // public function sortBynom() {
    //     return $this->createQueryBuilder('e')
    //         ->orderBy('e.nomV', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }
    // public function sortByville() {
    //     return $this->createQueryBuilder('e')
    //         ->orderBy('e.ville', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function findByCat($value): array
    // {
    //     return $this->createQueryBuilder('f')
    //         ->andWhere('f.adresseExpedition = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function rechercheParNomDeProduit($etat)
    // {
    //     $qb = $this->createQueryBuilder('p')
    //         ->where('p.etat LIKE  :x')
    //         ->setParameter('x', $etat);
    //     return $qb->getQuery()->getResult();
    // }

    // public function rechercheParNomDeProduit($recherche)
    // {
    //     $qb = $this->createQueryBuilder('p')
    //         ->where('p.etat LIKE :recherche')
    //         ->orWhere('p.etat LIKE :recherche')
    //         ->setParameter('recherche', $recherche . '%');
    //     return $qb->getQuery()->getResult();
    // }
    //    public function findOneBySomeField($value): ?Livraison
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
