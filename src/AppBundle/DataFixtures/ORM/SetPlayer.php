<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SetPlayer extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 60; ++$i) {
            $player = new Player();
            $player->setFirstname($faker->firstName);
            $player->setLastname($faker->lastName);
            $player->setPassword($encoder->encodePassword($player, 'test'));
            $player->setEmail($faker->email);
            $player->setAddress($faker->address);
            $player->setDateOfBirth($faker->dateTime());
            $player->setUsername($faker->userName.$i);
            $player->setPhoneNumber($faker->phoneNumber);
            $manager->persist($player);
        }
        $manager->flush();
    }
}