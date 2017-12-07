<?php


namespace Tests\TestBundle;


use AppBundle\Entity\Admin;

trait LoginTrait
{
    public function logIn()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');


        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $encoder = $client->getContainer()->get('security.password_encoder');

        $admin = new Admin();
        $admin->setPassword($encoder->encodePassword($admin, 'test'));
        $admin->setUsername('test');
        $admin->setEmail('test@test.com');

        $em->persist($admin);
        $em->flush();

        $nodeButton = $crawler->selectButton('Connexion');

        $form = $nodeButton->form();
        $form['_username'] = 'test';
        $form['_password'] = 'test';

        $client->submit($form);
        $client->followRedirect();

        return $client;
    }
}