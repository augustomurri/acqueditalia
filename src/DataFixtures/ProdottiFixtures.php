<?php

namespace App\DataFixtures;

use App\Entity\Comuni;
use App\Entity\Prodotti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProdottiFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $nomi = [
            'Acqua naturale',
            'Acqua gassata'
        ];

        foreach ($nomi as $nome) {
            $prodotto = new Prodotti();
            $prodotto->setNome($nome);
            $prodotto->setPrezzoUnitario(0.05);
            $manager->persist($prodotto);
        }

        $manager->flush();

    }


}
