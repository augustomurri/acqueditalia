<?php

namespace App\Repository;

use App\Entity\Erogazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Erogazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Erogazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Erogazioni[]    findAll()
 * @method Erogazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErogazioniRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Erogazioni::class);
        $this->security = $security;
    }

    public function getErogazioni()
    {
        $query = $this->createQueryBuilder('e')
            ->select('e, te, s, p')
            ->leftJoin('e.tessera', 'te')
            ->leftJoin('te.utente', 'u')
            ->leftJoin('e.prodotto', 'p')
            ->leftJoin('e.stazione', 's')
            ->groupBy('e, te, s, p')
            ->orderBy('e.createdAt', 'DESC')
            ->getQuery();

        $utente = $this->security->getUser();

        if ($this->security->isGranted('ROLE_GESTORE')) {
            $query->andWhere('u.utente = :current_gestore');
            $query->setParameter('current_gestore', $utente);
        }

        return $query;
    }

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
