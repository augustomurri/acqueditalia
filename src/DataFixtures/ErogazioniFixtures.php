<?php

namespace App\DataFixtures;

use App\Entity\Erogazioni;
use App\Entity\Prodotti;
use App\Entity\Stazioni;
use App\Entity\Tessere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ErogazioniFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $prodotti = $manager->getRepository(Prodotti::class)->findAll();
        $tessere = $manager->getRepository(Tessere::class)->findAll();
        $stazioni = $manager->getRepository(Stazioni::class)->findAll();

        for ($i=0;$i<=2000; $i++) {

            $erogazione = new Erogazioni();
            $erogazione->setTessera($tessere[array_rand($tessere)]);

            $prodotto = $prodotti[array_rand($prodotti)];
            $quantita = rand(1,4);
            $costo = $quantita * $prodotto->getPrezzoUnitario();

            $stazione = $stazioni[array_rand($stazioni)];
            $erogazione->setStazione($stazione);

            $erogazione->setProdotto($prodotto);
            $erogazione->setDataOra($this->randomDate('01-01-2021','31-12-2021'));
            $erogazione->setCosto($costo);
            $erogazione->setQuantita($quantita);

            $manager->persist($erogazione);
            $manager->flush();
        }

    }

    private function randomDate($start_date, $end_date) {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return \DateTime::createFromFormat('Y-m-d', "2018-09-09");
    }

    public function getDependencies(): array
    {
        return [
            UtentiFixtures::class,
            StazioniFixtures::class
        ];
    }

}
