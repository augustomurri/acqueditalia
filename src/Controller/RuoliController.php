<?php

namespace App\Controller;

use App\Entity\Comuni;
use App\Entity\Ruoli;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuoliController extends AbstractController
{
    /**
     * @Route("/ruoli", name="ruoli")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $params['ruoli'] = $em
            ->createQueryBuilder()
            ->select('r.id, r.nome, r.ruolo, r.classe, COUNT(u) AS totale_utenti')
            ->from(Ruoli::class, 'r')
            ->leftJoin('r.utenti', 'u')
            ->groupBy('r.id')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('ruoli/index.html.twig', $params);
    }
}
