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


}
