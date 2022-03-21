<?php

namespace App\Controller;

use App\Entity\Stazioni;
use App\Form\StazioniType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class StazioniController extends AbstractController
{
    /**
     * @Route("/stazioni", name="stazioni")
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("stazioni"));

        $query = $em->getRepository(Stazioni::class)->getStazioni();
dump($query->getResult());
        $params['stazioni'] = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10
        );

        return $this->render('stazioni/index.html.twig', $params);
    }

    /**
     *
     * @Route("/stazioni/edit/{id}", name="stazioni_edit", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function edit(Stazioni $stazione, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("stazioni"));
        $breadcrumbs->addItem("Modifica stazione");

        $formStazione = $this->createForm(StazioniType::class, $stazione);
        $formStazione->handleRequest($request);

        if ($formStazione->isSubmitted() && $formStazione->isValid()) {
            $dati = $formStazione->getData();
            $em->persist($dati);
            $em->flush();
            $this->addFlash('success', 'Dati modificati');
        }

        $params['form_stazione'] = $formStazione->createView();
        $params['stazione'] = $stazione;

        return $this->render('stazioni/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/stazioni/add", name="stazioni_add")
     *
     */
    public function add(Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("stazioni"));
        $breadcrumbs->addItem("Aggiungi stazione");

        $formStazione = $this->createForm(StazioniType::class);
        $formStazione->handleRequest($request);

        if ($formStazione->isSubmitted() && $formStazione->isValid()) {
            $dati = $formStazione->getData();
            $em->persist($dati);
            $em->flush();
            $this->addFlash('success', 'Dati modificati');
        }

        $params['form_stazione'] = $formStazione->createView();

        return $this->render('stazioni/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/stazioni/detail/{id}", name="stazioni_detail", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function view(Stazioni $stazione, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("stazioni"));
        $breadcrumbs->addItem("Dettagli stazione");

        $params['stazione'] = $stazione;

        return $this->render('stazioni/detail.html.twig', $params);
    }

    /**
     *
     * @Route("/stazioni/delete/{id}", name="stazioni_delete", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function delete(Stazioni $stazione, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $this->addFlash('success', 'Dati modificati');
        return $this->render('stazioni/index.html.twig');
    }
}
