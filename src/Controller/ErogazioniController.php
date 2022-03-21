<?php

namespace App\Controller;

use App\Entity\Erogazioni;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ErogazioniController extends AbstractController
{
    /**
     * @Route("/erogazioni", name="erogazioni")
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Erogazioni");

        $query = $em->getRepository(Erogazioni::class)->getErogazioni();

        $params['erogazioni'] = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            50
        );

        return $this->render('erogazioni/index.html.twig', $params);
    }
}
