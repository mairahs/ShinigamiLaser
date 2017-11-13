<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $card = new Card();
            $card->setStatus('status');
            $card->setNumber($i);
            $manager->persist($card);
        }

        $manager->flush();
    }
}