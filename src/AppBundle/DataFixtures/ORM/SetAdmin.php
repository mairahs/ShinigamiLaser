<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 29/11/2017
 * Time: 21:48.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SetAdmin extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; ++$i) {
            $admin = new Admin();
            $admin->setUsername($faker->userName);
            $admin->setEmail($faker->email);
            $admin->setPassword($encoder->encodePassword($admin, 'test+'));
            $manager->persist($admin);
        }
        $manager->flush();
    }
}
