<?php


namespace Tests\TestBundle;

use AppBundle\Entity\Admin;

trait LoginTrait
{
    public function logIn()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');

        $nodeButton = $crawler->selectButton('Connexion');

        $form = $nodeButton->form();
        $form['_username'] = 'test';
        $form['_password'] = 'test';

        $client->submit($form);
        $client->followRedirect();

        return $client;


    }
}