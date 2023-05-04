<?php

namespace App\Repository;

use App\Entity\OffreCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OffreCourse>
 *
 * @method OffreCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreCourse[]    findAll()
 * @method OffreCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreCourse::class);
    }

    public function save(OffreCourse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OffreCourse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OffreCourse[] Returns an array of OffreCourse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OffreCourse
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function countPeopleByTypeDon(): array
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.statut_offre as StatutOffre, COUNT(DISTINCT d.IdOffre) as count')
            ->groupBy('d.statut_offre')
            ->getQuery();

        return $qb->getResult();
    }
   /* public function sortByOptionOffre()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.optionsOffre', 'ASC')
            ->getQuery()
            ->getResult();
    }*/
    public function sortByprix() {
        return $this->createQueryBuilder('o')
            ->orderBy('o.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    
    public function sortByIdOffre() {
        return $this->createQueryBuilder('o')
            ->orderBy('o.idOffre', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function sortByMatricule() {
        return $this->createQueryBuilder('o')
            ->orderBy('o.matriculeVehicule', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function sortByPAssagers() {
        return $this->createQueryBuilder('o')
            ->orderBy('o.nbPassagers', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
