<?php

namespace App\Repository;

use App\Entity\GroupPromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupPromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupPromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupPromo[]    findAll()
 * @method GroupPromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupPromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupPromo::class);
    }

    // /**
    //  * @return GroupPromo[] Returns an array of GroupPromo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupPromo
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
