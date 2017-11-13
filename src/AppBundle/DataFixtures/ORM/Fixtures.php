<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Card;
use AppBundle\Entity\Etablishment;
use AppBundle\Entity\Player;
use AppBundle\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Factory;

/**
 * Class Fixtures
 * @package AppBundle\DataFixtures\ORM
 * php bin/console doctrine:fixtures:load
 */
class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 2; $i++) {
            $card = new Card();
            $card->setStatus('status');
            $card->setNumber($i);
            $manager->persist($card);
        }

        for ($i = 0; $i < 5; $i++) {
            $etablishment = new Etablishment();
            $etablishment->setName($faker->lastName);
            $etablishment->setCity($faker->city);
            $manager->persist($etablishment);
        }

        for ($i = 0; $i < 5; $i++) {
            $player = new Player();
            $player->setFirstname($faker->firstName);
            $player->setLastname($faker->lastName);
            $player->setPassword($faker->password);
            $player->setEmail($faker->email);
            $player->setAddress($faker->address);
            $player->setDateOfBirth($faker->dateTime());
            $player->setNickname($faker->firstName);
            $player->setPhoneNumber($faker->phoneNumber);
            $manager->persist($player);
        }

        for ($i = 0; $i < 5; $i++) {
            $provider = new Provider();
            $provider->setAdress($faker->address);
            $provider->setName($faker->lastName);
            $manager->persist($provider);
        }


        $manager->flush();
    }
}