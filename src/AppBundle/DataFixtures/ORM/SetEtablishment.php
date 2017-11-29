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
        for ($i = 0; $i < 5; ++$i) {
            $etablishment = new Etablishment();
            $etablishment->setName($faker->lastName);
            $etablishment->setCity($faker->city);
            $etablishment->setCode(rand(111, 999));
            $manager->persist($etablishment);
        }
        $manager->flush();
    }
}