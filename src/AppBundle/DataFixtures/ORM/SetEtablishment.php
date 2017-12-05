<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Etablishment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SetEtablishment extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; ++$i) {
            $etablishment = new Etablishment();
            $etablishment->setName($faker->lastName);
            $etablishment->setCity($faker->city);
            //todo faire un random de 001 à 999
            $etablishment->setCode(rand(111, 999));
            $manager->persist($etablishment);
        }
        $manager->flush();
    }
}