<?php

namespace App\Repository;

use App\Entity\Stazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stazioni[]    findAll()
 * @method Stazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StazioniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stazioni::class);
    }

    // /**
    //  * @return Stazioni[] Returns an array of Stazioni objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stazioni
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
