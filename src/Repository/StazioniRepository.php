<?php

namespace App\Repository;

use App\Entity\Stazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Stazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stazioni[]    findAll()
 * @method Stazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StazioniRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Stazioni::class);
        $this->security = $security;
    }

    public function getStazioni()
    {
        $query = $this->createQueryBuilder('s')
            //->select('s.id, s.nome, u.id, u.nome AS nome_gestore, c.nome AS nome_comune, COUNT(s.id) AS totale_erogazioni')
            ->select('s, u, c, COUNT(e.id) AS totale_erogazioni')
            ->leftJoin('s.gestore', 'u')
            ->leftJoin('s.comune', 'c')
            ->leftJoin('s.erogazioni', 'e')
            //->groupBy('s.id, c.nome, s.id, u.id')
            ->groupBy('s, u, c')
            ->orderBy('s.nome', 'ASC');

        $utente = $this->security->getUser();

        /*
        if ($this->security->isGranted('ROLE_MANAGER')) {
            $query->where('u.gestore = :current_gestore');
            $query->setParameter('current_gestore', $utente);
        }

        if ($this->security->isGranted('ROLE_CUSTOMER')) {
            $query->where('u.id = :current_utente');
            $query->setParameter('current_utente', $utente);
        }
        */

        $query = $query->getQuery();

        return $query;
    }
}
