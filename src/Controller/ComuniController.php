<?php

namespace App\Controller;

use App\Entity\Comuni;
use App\Form\ComuniType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ComuniController extends AbstractController
{
    /**
     * @Route("/comuni", name="comuni")
     */
    public function index(Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Comuni");

        $query = $em->getRepository(Comuni::class)->getComuni();
        $params['comuni'] = $query->getResult();

        return $this->render('comuni/index.html.twig', $params);
    }

    /**
     *
     * @Route("/comuni/edit/{id}", name="comuni_edit", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function edit(Comuni $comune, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_GESTORE')) {
            throw new AccessDeniedException('Only an admin can do this!!!!');
        }

        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Comuni", $this->get("router")->generate("comuni"));
        $breadcrumbs->addItem("Modifica comune");

        $formComune = $this->createForm(ComuniType::class, $comune);
        $formComune->handleRequest($request);

        if ($formComune->isSubmitted() && $formComune->isValid()) {
            $dati = $formComune->getData();
            $em->persist($dati);
            $em->flush();
            $this->addFlash('success', 'Dati modificati');
        }

        $params['form_comune'] = $formComune->createView();
        $params['comune'] = $comune;

        return $this->render('comuni/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/comuni/delete/{id}", name="comuni_delete", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function delete(Comuni $comune, EntityManagerInterface $em)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Only an admin can do this!!!!');
        }

        $this->addFlash('success', 'Comune eliminato con successo');

        $em->remove($comune);
        $em->flush();

        return $this->redirectToRoute('comuni_index');
    }
}
