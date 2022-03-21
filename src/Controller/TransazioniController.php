<?php

namespace App\Controller;

use App\Entity\Comuni;
use App\Entity\Transazioni;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\FetchJoinORMAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class TransazioniController extends AbstractController
{
    /**
     * @Route("/transazioni", name="transazioni")
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Transazioni");

        $query = $em
            ->createQueryBuilder()
            ->select('t, o, u')
            ->from(Transazioni::class, 't')
            ->leftJoin('t.operatore', 'o')
            ->leftJoin('t.utente', 'u')
            ->groupBy('t.id, u.id, o.id')
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery();

        $params['transazioni'] = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            50
        );

        return $this->render('transazioni/index.html.twig', $params);
    }
}
