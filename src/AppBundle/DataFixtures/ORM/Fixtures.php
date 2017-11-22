<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Admin;
use AppBundle\Entity\Card;
use AppBundle\Entity\Etablishment;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Score;
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

        $etablishment_arr = [];
        for ($i = 0; $i < 5; $i++) {
            $etablishment = new Etablishment();
            $etablishment->setName($faker->lastName);
            $etablishment->setCity($faker->city);
            $etablishment->setCode(rand(111,999));
            $manager->persist($etablishment);
            $etablishment_arr[] = $etablishment;
        }

        $player_arr = [];
        for ($i = 0; $i < 10; $i++) {
            $player = new Player();
            $player->setFirstname($faker->firstName);
            $player->setLastname($faker->lastName);
            $player->setPassword($encoder->encodePassword($player, 'test'));
            $player->setEmail($faker->email);
            $player->setAddress($faker->address);
            $player->setDateOfBirth($faker->dateTime());
            $player->setUsername($faker->firstName);
            $player->setToken(987987987);
            $player->setPhoneNumber($faker->phoneNumber);
            $player->setIsActivate(0);
            $manager->persist($player);
            $player_arr[] = $player;
        }

        $card_arr = [];
        for ($i = 0; $i < 20; $i++) {
            $card = new Card();
            $rand = rand(1,5);
            if(4 > $rand){
                $key = array_rand($player_arr, 1);
                $card->setPlayer($player_arr[$key]);

                $key_ = array_rand($etablishment_arr, 1);
                $card->setEtablishment($etablishment_arr[$key_]);

                $card->setStatus('active');
                $card_arr[] = $card;
            }else{
                $card->setStatus('in_store');
            }
            $manager->persist($card);
        }

        for ($i = 0; $i < 15; $i++) {
            $game = new Game();
            $game->setType('deathmatch');

            $date = new \DateTime();
            $date->modify("+$i day");
            $game->setPlayedAt($date);

            $key_ = array_rand($etablishment_arr, 1);
            $game->setEtablishment($etablishment_arr[$key_]);


            foreach($card_arr as $card){
                $rand = rand(1,3);
                if(3 > $rand){
                    $score = new Score();
                    $score->setResult(rand(100, 1000));
                    $score->setRank('super tireur');
                    $score->setTeam(0);
                    $score->setCards($card);
                    $score->setGames($game);
                    $manager->persist($score);
                }
            }
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