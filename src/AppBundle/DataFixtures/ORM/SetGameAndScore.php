<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 21:50
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Game;
use AppBundle\Entity\Score;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetGameAndScore extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gametype_arr = [
            'Team' => [
                'min' => 300,
                'max' => 1100,
            ],
            'FFA' => [
                'min' => 800,
                'max' => 2000,
            ],
            'Dracula' => [
                'min' => 20,
                'max' => 100,
            ],
        ];
        $etablishments = $manager->getRepository('AppBundle:Etablishment')->findAll();
        $time_slots = $manager->getRepository('AppBundle:TimeSlot')->findAll();
        $game_types = $manager->getRepository('AppBundle:GameType')->findAll();
        $cards = $manager->getRepository('AppBundle:Card')->findBy(['status' => 'active']);

        for ($i = 0; $i < 30; ++$i) {
            $game = new Game();

            $date = new \DateTime();
            $date->modify("+$i day");
            $game->setPlayedAt($date);

            $key_e = array_rand($etablishments, 1);
            $game->setEtablishment($etablishments[$key_e]);

            $key_ts = array_rand($time_slots, 1);
            $game->setTimeSlot($time_slots[$key_ts]);

            $game->setNbMax(rand(20, 25));

            $game->setBooking(0);

            $key_gt = array_rand($game_types, 1);
            $game->setGameType($game_types[$key_gt]);
            $get_type = $game_types[$key_gt]->getType();

            $rand_min_max = $gametype_arr[$get_type];

            foreach ($cards as $card) {
                $rand = rand(1, 3);
                if (3 > $rand) {
                    $score = new Score();
                    $score->setResult(rand($rand_min_max['min'], $rand_min_max['max']));
                    if ('Team' == $get_type) {
                        $score->setTeam(rand(1, 2));
                    } else {
                        $score->setTeam(0);
                    }
                    $score->setCards($card);
                    $score->setGames($game);
                    $manager->persist($score);
                }
            }
        }
        $manager->flush();

        /**** Ceci pour setter le booking à 0 parce que celui-ci est en prepersist en donc ici nous sommes en update *****/
        $games = $manager->getRepository('AppBundle:Game')->findAll();
        foreach ($games as $game) {
            $game->setBooking(0);
            $manager->persist($game);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            SetEtablishment::class,
            SetTimeSlot::class,
            SetGameType::class,
            SetCard::class
        );
    }
}