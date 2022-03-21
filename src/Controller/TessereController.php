<?php

namespace App\Controller;

use App\Entity\Stazioni;
use App\Entity\Tessere;
use App\Form\StazioniType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class TessereController extends AbstractController
{
    /**
     * @Route("/tessere", name="tessere")
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Tessere", 'Tessere');

        $query = $em
            ->createQueryBuilder()
            ->select('te.id, te.codice_tessera, u.nome, u.cognome, COUNT(e.id) AS totale_erogazioni')
            ->from(Tessere::class, 'te')
            ->leftJoin('te.utente', 'u')
            ->leftJoin('te.erogazioni', 'e')
            ->groupBy('te, u')
            ->getQuery();

        $params['tessere'] = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10
        );

        return $this->render('tessere/index.html.twig', $params);
    }

}
