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
        for ($i = 0; $i < 5; ++$i) {
            $command = new Command();
            $command->setPrice(rand(150,300));
            $key = array_rand($etablissements, 1);
            $command->setEtablishment($etablissements[$key]);
            $command->setQuantity(4);
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