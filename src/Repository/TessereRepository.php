<?php

namespace App\Repository;

use App\Entity\Tessere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tessere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tessere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tessere[]    findAll()
 * @method Tessere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TessereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tessere::class);
    }

    // /**
    //  * @return Tessere[] Returns an array of Tessere objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tessere
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
