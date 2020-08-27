<?php

namespace App\Repository;

use App\Entity\FilDeDiscussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilDeDiscussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilDeDiscussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilDeDiscussion[]    findAll()
 * @method FilDeDiscussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilDeDiscussionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilDeDiscussion::class);
    }

    // /**
    //  * @return FilDeDiscussion[] Returns an array of FilDeDiscussion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilDeDiscussion
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
