<?php

namespace App\DataFixtures;

use App\Entity\Comuni;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ComuniFixtures extends Fixture
{
    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('it_IT');
    }

    public function load(ObjectManager $manager): void
    {
        $comuni[] = array('nome' => 'Cupra Marittima', 'latitudine' => '43.030949', 'longitudine' => '13.858920');
        $comuni[] = array('nome' => 'Pedaso', 'latitudine' => '43.100170', 'longitudine' => '13.841720');
        $comuni[] = array('nome' => 'Porto San Giorgio', 'latitudine' => '43.183780', 'longitudine' => '13.794390');
        $comuni[] = array('nome' => 'Comunanza', 'latitudine' => '42.958462', 'longitudine' => '13.413300');
        $comuni[] = array('nome' => 'Roma', 'latitudine' => '41.902782', 'longitudine' => '12.496365');
        $comuni[] = array('nome' => 'Ancona', 'latitudine' => '43.615829', 'longitudine' => '13.518915');

        foreach ($comuni as $c) {
            $comune = new Comuni();
            $comune->setNome($c['nome']);
            $comune->setLatitudine($this->faker->latitude($c['latitudine'],$c['latitudine']));
            $comune->setLongitudine($this->faker->longitude($c['longitudine'],$c['longitudine']));
            $manager->persist($comune);
        }

        $manager->flush();

    }

}
