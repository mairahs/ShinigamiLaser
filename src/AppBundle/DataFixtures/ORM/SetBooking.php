<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 16:15
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class Fixtures.
 */
class SetBooking extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**** TOUS CA POUR SETTER LES PARTIES A BOOKING = 0 ...... *****/
        $games = $manager->getRepository('AppBundle:Game')->findAll();
        foreach ($games as $game) {
            $game->setBooking(0);
            $manager->persist($game);
        }
        $manager->flush();
    }
}