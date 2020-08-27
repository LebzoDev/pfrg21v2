<?php

namespace App\Repository;

use App\Entity\Apprenants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apprenants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apprenants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apprenants[]    findAll()
 * @method Apprenants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApprenantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apprenants::class);
    }

    // /**
    //  * @return Apprenants[] Returns an array of Apprenants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apprenants
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
