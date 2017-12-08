<?php


namespace Tests\TestBundle;


use AppBundle\Entity\Command;
use AppBundle\Entity\Etablishment;
use AppBundle\Entity\Game;
use AppBundle\Entity\GameType;
use AppBundle\Entity\TimeSlot;
use Doctrine\ORM\EntityManager;

trait DatabaseTrait
{
    public function generateDatabase(EntityManager $em)
    {
        $etablishment1 = new Etablishment();
        $etablishment1->setName('etablishment1');
        $etablishment1->setCity('ville');
        $etablishment1->setCode('123');
        $em->persist($etablishment1);

        $command1 = new Command();
        $command1->setEtablishment($etablishment1);
        $command1->setQuantity(2);
        $command1->setPrice(30);
        $command1->setDateOfOrder(new \Datetime('2017-12-20'));
        $em->persist($command1);

        $time_slot1 = new TimeSlot();
        $time_slot1->setType('8h-10h');
        $em->persist($time_slot1);

        $game_type1 = new GameType();
        $game_type1->setType('Team');
        $game_type1->setTeam(1);
        $em->persist($game_type1);

        $game1 = new Game();
        $game1->setPlayedAt(new \DateTime());
        $game1->setEtablishment($etablishment1);
        $game1->setGameType($game_type1);
        $game1->setTimeSlot($time_slot1);
        $em->persist($etablishment1);

        $em->flush();
    }
}