<?php

namespace App\DataFixtures;

use App\Entity\Comuni;
use App\Entity\Stazioni;
use App\Entity\Utenti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StazioniFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('it_IT');
    }

    public function load(ObjectManager $manager): void
    {
        $comuni = $manager->getRepository(Comuni::class)->findAll();
        $gestori = $manager
            ->createQueryBuilder('u')
            ->select('u, r')
            ->from(Utenti::class,'u')
            ->leftJoin('u.ruolo', 'r')
            ->where('r.ruolo = :ruolo')
            ->setParameter('ruolo', 'ROLE_MANAGER')
            ->getQuery()
            ->getResult();

        foreach ($comuni as $comune) {
            $number = rand(3,20);
            for ($i=0;$i<=$number;$i++) {
                $stazione = new Stazioni();
                $stazione->setComune($comune);

                $gestore = $gestori[array_rand($gestori)];
                $stazione->setGestore($gestore);

                $stazione->setLatitudine($comune->getLatitudine());
                $stazione->setLongitudine($comune->getLongitudine());
                $stazione->setNome($this->faker->words(2, true));
                $manager->persist($stazione);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ComuniFixtures::class
        ];
    }

}
