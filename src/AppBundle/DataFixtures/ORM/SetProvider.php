<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 30/11/2017
 * Time: 09:03
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SetProvider extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; ++$i) {
            $provider = new Provider();
            $provider->setAdress($faker->address);
            $provider->setName($faker->lastName);
            $manager->persist($provider);
        }
        $manager->flush();
    }
}