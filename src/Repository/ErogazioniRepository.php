<?php

namespace App\Repository;

use App\Entity\Erogazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Erogazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Erogazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Erogazioni[]    findAll()
 * @method Erogazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErogazioniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Erogazioni::class);
    }

    // /**
    //  * @return Erogazioni[] Returns an array of Erogazioni objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Erogazioni
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
