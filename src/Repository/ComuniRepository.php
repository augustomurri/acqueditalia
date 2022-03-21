<?php

namespace App\Repository;

use App\Entity\Comuni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Comuni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comuni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comuni[]    findAll()
 * @method Comuni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComuniRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Comuni::class);
        $this->security = $security;
    }

    public function getComuni()
    {
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.nome, COUNT(s) AS totale_stazioni, COUNT(u) AS totale_utenti')
            ->leftJoin('c.stazioni', 's')
            ->leftJoin('c.utenti', 'u')
            ->groupBy('c.id');

        $utente = $this->security->getUser();

        if ($this->security->isGranted('ROLE_MANAGER')) {
            $query->where('u.gestore = :current_gestore');
            $query->setParameter('current_gestore', $utente);
        }

        if ($this->security->isGranted('ROLE_CUSTOMER')) {
            $query->where('u.id = :current_utente');
            $query->setParameter('current_utente', $utente);
        }

        $query = $query->getQuery();

        return $query;
    }
}
