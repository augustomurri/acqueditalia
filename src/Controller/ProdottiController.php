<?php

namespace App\Controller;

use App\Entity\Prodotti;
use App\Form\ProdottiType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ProdottiController extends AbstractController
{
    /**
     * @Route("/prodotti", name="prodotti")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $params['prodotti'] = $em
            ->createQueryBuilder()
            ->select('p.id, p.nome, p.prezzo_unitario, COUNT(e.id) AS totale_erogazioni')
            ->from(Prodotti::class, 'p')
            ->leftJoin('p.erogazioni', 'e')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();

        return $this->render('prodotti/index.html.twig', $params);
    }

    /**
     *
     * @Route("/prodotti/edit/{id}", name="prodotti_edit", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function edit(Prodotti $prodotto, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_GESTORE')) {
            throw new AccessDeniedException('Only an admin can do this!!!!');
        }

        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Comuni", $this->get("router")->generate("prodotti"));
        $breadcrumbs->addItem("Modifica prodotto");

        $formProdotto = $this->createForm(ProdottiType::class, $prodotto);
        $formProdotto->handleRequest($request);

        if ($formProdotto->isSubmitted() && $formProdotto->isValid()) {
            $dati = $formProdotto->getData();
            $em->persist($dati);
            $em->flush();
            $this->addFlash('success', 'Dati modificati');
        }

        $params['form_prodotto'] = $formProdotto->createView();
        $params['prodotto'] = $prodotto;

        return $this->render('prodotti/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/prodotti/delete/{id}", name="prodotti_delete", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function delete(Prodotti $prodotto, EntityManagerInterface $em)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Only an admin can do this!!!!');
        }

        $this->addFlash('success', 'Prodotto eliminato con successo');

        $em->remove($prodotto);
        $em->flush();

        return $this->redirectToRoute('prodotti');
    }
}
