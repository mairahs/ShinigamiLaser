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
        $cards = $manager->getRepository('AppBundle:Card')->findAll();
        $players = $manager->getRepository('AppBundle:Player')->findAll();
        foreach($cards as $card) {
            $rand = rand(1, 10);
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
            SetCommand::class
        );
    }
}