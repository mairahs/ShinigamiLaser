<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 21:50
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\TimeSlot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetTimeSlot extends Fixture

{
    public function load(ObjectManager $manager)
    {
        $timeslot_arr = [
            '9h-11h' => [
                'start' => 9,
                'end' => 11,
            ],
            '14h-16h' => [
                'start' => 14,
                'end' => 16,
            ],
            '17h-19h' => [
                'start' => 17,
                'end' => 19,
            ]
        ];
        foreach ($timeslot_arr as $type => $value) {
            $time_slot = new TimeSlot();
            $time_slot->setType($type);
            $manager->persist($time_slot);
        }
        $manager->flush();
    }
}