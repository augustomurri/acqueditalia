<?php

namespace App\DataFixtures;

use App\Entity\Comuni;
use App\Entity\Tessere;
use App\Entity\Utenti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UtentiFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_USER_REFERENCE = 'USER_ADMIN';

    /** @var Generator */
    protected $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create('it_IT');

    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Utenti();
        $admin->setAttivo(1);
        $admin->setIsVerified(1);
        $admin->setGestore(null);
        $admin->setNome('Acqua');
        $admin->setCognome('D\'Italia Srl');
        $admin->setEmail('info@augustomurri.it');
        $admin->setCodiceFiscale($this->faker->taxId());

        $password = $this->hasher->hashPassword($admin, 'Ma31051983#');
        $admin->setPassword($password);

        $admin->setRuolo($this->getReference(RuoliFixtures::ADMIN_ROLE_REFERENCE));

        $manager->persist($admin);
        $manager->flush();

        $comuni = $manager->getRepository(Comuni::class)->findAll();

        $i=0;
        $gestori = [];
        foreach ($comuni as $comune) { $i++;

            $gestore = new Utenti();
            $gestore->setAttivo(1);
            $gestore->setIsVerified(1);
            $gestore->setComune($comune);
            $gestore->setNome($this->faker->company());
            $gestore->setCognome($this->faker->companySuffix());
            $gestore->setEmail($this->faker->email());
            $gestore->setCodiceFiscale($this->faker->taxId());

            $password = $this->hasher->hashPassword($admin, 'Ma31051983#');
            $gestore->setPassword($password);

            $gestore->setRuolo($this->getReference(RuoliFixtures::MANAGER_ROLE_REFERENCE));

            $manager->persist($gestore);
            $manager->flush();

            $gestori[] = $gestore;
        }

        for ($i=1;$i<=10;$i++) {

            $utente = new Utenti();
            $utente->setAttivo(1);
            $utente->setIsVerified(1);
            $utente->setGestore($gestori[rand(0,2)]);
            $utente->setEmail($this->faker->unique()->email());
            $utente->setNome($this->faker->firstName());
            $utente->setCognome($this->faker->lastName());
            $utente->setCodiceFiscale($this->faker->taxId());

            $comune = $comuni[array_rand($comuni)];
            $utente->setComune($comune);

            $password = $this->hasher->hashPassword($utente, 'Ma31051983#');
            $utente->setPassword($password);

            $utente->setRuolo($this->getReference(RuoliFixtures::CUSTOMER_ROLE_REFERENCE));

            $n_tessere = rand(1,4);
            for ($y=1;$y<=$n_tessere;$y++) {

                $tessera = new Tessere();
                $tessera->setAttiva(true);
                $tessera->setCodiceTessera($this->faker->randomNumber(5, true));
                $tessera->setDataAttivazione($this->faker->dateTimeBetween('-1 year', '+1 year'));
                $tessera->setUtente($utente);
                $manager->persist($tessera);

            }

            $manager->persist($utente);
            $manager->flush();
        }

    }

    public function getDependencies()
    {
        return [
            RuoliFixtures::class,
            ComuniFixtures::class
        ];
    }
}
