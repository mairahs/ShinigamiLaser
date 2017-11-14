<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Admin;
use AppBundle\Entity\Card;
use AppBundle\Entity\Etablishment;
use AppBundle\Entity\Player;
use AppBundle\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

        $encoder = $this->container->get('security.password_encoder');

        for ($i = 0; $i < 2; $i++) {
            $card = new Card();
            $card->setStatus('in_store');
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
            $player->setPassword($encoder->encodePassword($player, 'test'));
            $player->setEmail($faker->email);
            $player->setAddress($faker->address);
            $player->setDateOfBirth($faker->dateTime());
            $player->setUsername($faker->firstName);
            $player->setPhoneNumber($faker->phoneNumber);
            $manager->persist($player);
        }

        for ($i = 0; $i < 5; $i++) {
            $admin = new Admin();
            $admin->setUsername($faker->userName);
            $admin->setEmail($faker->email);
            $admin->setPassword($encoder->encodePassword($admin, 'test+'));
            $manager->persist($admin);
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