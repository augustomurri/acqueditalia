<?php

namespace App\Repository;

use App\Entity\Prodotti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prodotti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prodotti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prodotti[]    findAll()
 * @method Prodotti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdottiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prodotti::class);
    }

    // /**
    //  * @return Prodotti[] Returns an array of Prodotti objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prodotti
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
