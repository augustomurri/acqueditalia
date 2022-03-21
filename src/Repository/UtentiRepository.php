<?php

namespace App\Repository;

use App\Entity\Utenti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utenti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utenti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utenti[]    findAll()
 * @method Utenti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtentiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utenti::class);
    }

    public function loadUserByUsername($username)
    {
        return $this
            ->createQueryBuilder('u')
            ->select('u, g')
            ->leftJoin('u.groups', 'g')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
