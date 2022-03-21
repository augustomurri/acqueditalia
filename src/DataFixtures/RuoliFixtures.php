<?php

namespace App\DataFixtures;

use App\Entity\Ruoli;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RuoliFixtures extends Fixture
{
    public const ADMIN_ROLE_REFERENCE = 'ROLE_ADMIN';
    public const MANAGER_ROLE_REFERENCE = 'ROLE_MANAGER';
    public const OPERATOR_ROLE_REFERENCE = 'ROLE_OPERATOR';
    public const CUSTOMER_ROLE_REFERENCE = 'ROLE_CUSTOMER';

    public function load(ObjectManager $manager): void
    {
        $ruolo = new Ruoli();
        $ruolo->setNome('Amministratore');
        $ruolo->setRuolo('ROLE_ADMIN');
        $ruolo->setClasse('bg-danger-light');
        $manager->persist($ruolo);
        $this->addReference(self::ADMIN_ROLE_REFERENCE, $ruolo);

        $ruolo = new Ruoli();
        $ruolo->setNome('Gestore');
        $ruolo->setRuolo('ROLE_MANAGER');
        $ruolo->setClasse('bg-warning-light');
        $manager->persist($ruolo);
        $this->addReference(self::MANAGER_ROLE_REFERENCE, $ruolo);

        $ruolo = new Ruoli();
        $ruolo->setNome('Operatore');
        $ruolo->setRuolo('ROLE_OPERATOR');
        $ruolo->setClasse('bg-info-light');
        $manager->persist($ruolo);
        $this->addReference(self::OPERATOR_ROLE_REFERENCE, $ruolo);

        $ruolo = new Ruoli();
        $ruolo->setNome('Cliente');
        $ruolo->setRuolo('ROLE_CUSTOMER');
        $ruolo->setClasse('bg-success-light');
        $manager->persist($ruolo);
        $this->addReference(self::CUSTOMER_ROLE_REFERENCE, $ruolo);

        $manager->flush();
    }
}
