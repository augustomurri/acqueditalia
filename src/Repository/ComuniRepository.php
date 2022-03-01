<?php

namespace App\Repository;

use App\Entity\Comuni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comuni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comuni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comuni[]    findAll()
 * @method Comuni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComuniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comuni::class);
    }

    // /**
    //  * @return Comuni[] Returns an array of Comuni objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comuni
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
