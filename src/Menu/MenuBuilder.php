<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private $factory;
    private $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav-main');

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {

            $menu
                ->addChild('Comuni', ['route' => 'comuni'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Prodotti', ['route' => 'prodotti'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Stazioni', ['route' => 'stazioni'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Erogazioni', ['route' => 'erogazioni'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Utenti', ['route' => 'utenti'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Ruoli', ['route' => 'ruoli'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');

            $menu['Utenti']
                ->addChild('Aggiungi utente', ['route' => 'utenti_add'])
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Tessere', ['route' => 'tessere'])
                ->setLinkAttribute('class', 'nav-main-link');

            $menu
                ->addChild('Transazioni', ['route' => 'transazioni'])
                ->setAttribute('class', 'nav-main-item')
                ->setLinkAttribute('class', 'nav-main-link');
        }

        /*
        if (in_array('ROLE_MANAGER', $this->user->getRoles())) {
            //$menu->addChild('Statistiche', ['route' => 'index_comune', 'routeParameters' => array('id' => $this->user->getComune()->getId())]);
            $menu->addChild('Stazioni', ['route' => 'stazioni']);
            $menu->addChild('Utenti', ['route' => 'utenti']);
            $menu->addChild('Transazioni', ['route' => 'transazioni']);
        }

        if (in_array('ROLE_CUSTOMER', $this->user->getRoles())) {
            $menu->addChild('Transazioni', ['route' => 'transazioni']);
        }
        */

        return $menu;
    }
}