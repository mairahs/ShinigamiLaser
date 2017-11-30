<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Command;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetCommand extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etablissements = $manager->getRepository('AppBundle:Etablishment')->findAll();
        foreach($etablissements as $etablishment) {
            $command = new Command();
            $command->setPrice(rand(150,300));
            $command->setEtablishment($etablishment);
            $command->setQuantity(rand(2,7));
            $command->setDateOfOrder(new \DateTime());
            $manager->persist($command);
            $arr_command[] = $command;
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            SetEtablishment::class
        );
    }
}