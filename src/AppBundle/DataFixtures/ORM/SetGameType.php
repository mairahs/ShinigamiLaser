<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 21:50
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\GameType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetGameType extends Fixture
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
        foreach ($gametype_arr as $type => $value) {
            $game_type = new GameType();
            $game_type->setType($type);
            $manager->persist($game_type);
        }
        $manager->flush();
    }
}