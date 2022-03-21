<?php

namespace App\Controller;

use App\Entity\Transazioni;
use App\Entity\Utenti;
use App\Form\UtentiManageType;
use App\Form\UtentiPasswordType;
use App\Form\UtentiBaseType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class UtentiController extends AbstractController
{
    /**
     * @Route("/utenti", name="utenti")
     */
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Utenti");

        $query = $em
            ->createQueryBuilder()
            ->select('u.id, u.nome, u.cognome, u.ultimo_login, c.nome AS comune, g.id AS id_gestore, g.nome AS nome_gestore, g.cognome AS cognome_gestore, r.nome AS nome_ruolo, r.ruolo, COUNT(te) AS totale_tessere')
            //->select('u')
            //->addSelect('c')
            //->addSelect('r')
            //->addSelect('COUNT(te) AS totale_tessere')
            ->from(Utenti::class, 'u')
            ->leftJoin('u.comune', 'c')
            ->leftJoin('u.gestore', 'g')
            ->leftJoin('u.tessere', 'te')
            ->leftJoin('u.ruolo', 'r')
            ->groupBy('u.id, g.id, c.id, r.id')
            ->getQuery();

        dump($query->getResult());
        $params['utenti'] = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10
        );

        return $this->render('utenti/index.html.twig', $params);
    }

    /**
     *
     * @Route("/utenti/edit/{id}", name="utenti_edit", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function edit(Utenti $utente, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs, UserPasswordHasherInterface $passwordHasher)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("utenti"));
        $breadcrumbs->addItem("Modifica utente");

        $formProfilo = $this->createForm(UtentiBaseType::class, $utente);
        $formProfilo->handleRequest($request);

        $formPassword = $this->createForm(UtentiPasswordType::class, $utente);
        $formPassword->handleRequest($request);

        if ($this->isGranted('ROLE_GESTORE') OR $this->isGranted('ROLE_ADMIN')) {
            $formManage = $this->createForm(UtentiManageType::class, $utente);
            $formManage->handleRequest($request);

            $params['form_manage'] = $formManage->createView();

            if ($formManage->isSubmitted() && $formManage->isValid()) {
                $dati = $formManage->getData();
                $em->persist($dati);
                $em->flush();
            }
        }

        if ($formProfilo->isSubmitted() && $formProfilo->isValid()) {

            $dati = $formProfilo->getData();
            $em->persist($dati);
            $em->flush();

            $this->addFlash('success', 'Dati modificati');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {

            $dati = $formPassword->getData();
            $encodedpassword = $passwordHasher->hashPassword($utente, $dati->getPassword());
            $dati->setPassword($encodedpassword);
            $em->persist($dati);
            $em->flush();

        }

        $params['form_profilo'] = $formProfilo->createView();
        $params['form_password'] = $formPassword->createView();

        $params['utente'] = $utente;

        $params['avatar'] = $utente->getAvatar();

        return $this->render('utenti/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/utenti/add", name="utenti_add")
     *
     */
    public function add(Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Utenti", $this->get("router")->generate("utenti"));
        $breadcrumbs->addItem("Aggiungi utente");

        $form = $this->createForm(UtentiBaseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Utente inserito');
        }

        $params['forms'] = $form->createView();

        return $this->render('utenti/edit.html.twig', $params);
    }

    /**
     *
     * @Route("/utenti/detail/{id}", name="utenti_detail", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function view(Utenti $utente, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Stazioni", $this->get("router")->generate("utenti"));
        $breadcrumbs->addItem("Dettagli utente");

        $params['utente'] = $utente;

        return $this->render('utenti/detail.html.twig', $params);
    }

    /**
     *
     * @Route("/utenti/delete/{id}", name="utenti_delete", requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     *
     */
    public function delete(Utenti $utente, Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs)
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_GESTORE')) {
            throw new AccessDeniedException('Only an admin can do this!!!!');
        }

        $this->addFlash('success', 'Utente eliminato con successo');

        $em->remove($utente);
        $em->flush();

        return $this->redirectToRoute('utenti');
    }

    /**
     * @Route("/profilo/modifica", name="profilo_modifica")
     */
    public function profilo(Request $request, EntityManagerInterface $em, Breadcrumbs $breadcrumbs, UserPasswordHasherInterface $passwordHasher)
    {
        return $this->edit($this->getUser(), $request, $em, $breadcrumbs, $passwordHasher);
    }
}
