<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 21:51
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetCard extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etablishments = $manager->getRepository('AppBundle:Etablishment')->findAll();
        $commands = $manager->getRepository('AppBundle:Command')->findAll();
        $players = $manager->getRepository('AppBundle:Player')->findAll();
        for ($i = 0; $i < 30; ++$i) {
            $card = new Card();
            $rand = rand(1, 10);

            $key_e = array_rand($etablishments, 1);
            $card->setEtablishment($etablishments[$key_e]);
            $key_c = array_rand($commands, 1);
            $card->setCommand($commands[$key_c]);

            if (10 !== $rand) {
                $key = array_rand($players, 1);
                $card->setPlayer($players[$key]);
                $card->setStatus('active');
            } else {
                $card->setStatus('in_store');
            }
            $manager->persist($card);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            SetEtablishment::class,
            SetCommand::class,
            SetPlayer::class
        );
    }
}