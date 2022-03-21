<?php

namespace App\DataFixtures;

use App\Entity\Transazioni;
use App\Entity\Utenti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TransazioniFixtures extends Fixture implements DependentFixtureInterface
{

    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('it_IT');
    }

    public function load(ObjectManager $manager): void
    {
        $gestori = $manager
            ->createQueryBuilder('u')
            ->select('u, r')
            ->from(Utenti::class,'u')
            ->leftJoin('u.ruolo', 'r')
            ->where('r.ruolo = :ruolo')
            ->setParameter('ruolo', 'ROLE_MANAGER')
            ->getQuery()
            ->getResult();

        $utenti = $manager
            ->createQueryBuilder('u')
            ->select('u, r')
            ->from(Utenti::class,'u')
            ->leftJoin('u.ruolo', 'r')
            ->where('r.ruolo = :ruolo')
            ->setParameter('ruolo', 'ROLE_CUSTOMER')
            ->getQuery()
            ->getResult();

        $tagli = array(5,10,15,50);

        $totali = [];
        for ($i=0;$i<=50; $i++) {

            $transazione = new Transazioni();

            $quantita = $tagli[array_rand($tagli)];
            $transazione->setQuantita($quantita);

            $gestore = $gestori[array_rand($gestori)];
            $transazione->setOperatore($gestore);

            $utente = $utenti[array_rand($utenti)];
            $transazione->setUtente($utente);

            $uuid = $utente->getId()->toBase32();
            if (isSet($totali[$uuid])) {
                $totali[$uuid] += $quantita;
            }else {
                $totali[$uuid] = 0;
            }

            $manager->persist($transazione);
        }

        foreach ($utenti as $utente) {
            $uuid = $utente->getId()->toBase32();
            if (isSet($totali[$uuid])) {
                $utente->setCredito($totali[$uuid]);
                $manager->persist($utente);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtentiFixtures::class
        ];
    }

}
