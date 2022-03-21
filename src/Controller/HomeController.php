<?php

namespace App\Controller;

use App\Entity\Comuni;
use App\Entity\Transazioni;
use App\Entity\Utenti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        /*
        $gestori = $manager
            ->createQueryBuilder('u')
            ->select('u, r')
            ->from(Utenti::class,'u')
            ->leftJoin('u.ruolo', 'r')
            ->where('r.ruolo = :ruolo')
            ->setParameter('ruolo', 'ROLE_MANAGER')
            ->getQuery()
            ->getResult();
        */

        /*
        $transazioni = $manager
            ->createQueryBuilder('t')
            ->select('t')
            ->addSelect('CONCAT(o.nome, \' \', o.cognome) AS operatore_fullname')
            ->addSelect('CONCAT(u.nome, \' \', u.cognome) AS utente_fullname')
            ->from(Transazioni::class, 't')
            ->leftJoin('t.operatore', 'o')
            ->leftJoin('t.utente', 'u')
            ->getQuery()
            ->getResult();

        dump($transazioni);
        */

        /*
        $comuni = $manager
            ->createQueryBuilder('c')
            ->select('c, u')
            ->addSelect('count(u) AS totaleUtenti')
            ->from(Comuni::class, 'c')
            ->leftJoin('c.utenti', 'u')
            ->groupBy('c.id, u.id')
            ->getQuery()
            ->getResult();
        dump($comuni);
        */

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
