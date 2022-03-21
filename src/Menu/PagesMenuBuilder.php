<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class PagesMenuBuilder
{
    private $factory;
    private $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->user = $security->getUser();
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Stazioni', ['route' => 'login']);
        $menu->addChild('Utenti', ['route' => 'registrazione']);

        return $menu;
    }
}