<?php

namespace App\Repository;

use App\Entity\Transazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transazioni[]    findAll()
 * @method Transazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransazioniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transazioni::class);
    }

    // /**
    //  * @return Transazioni[] Returns an array of Transazioni objects
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
    public function findOneBySomeField($value): ?Transazioni
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
