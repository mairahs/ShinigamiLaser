<?php

namespace Tests\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandControllerTest extends WebTestCase
{
    public function testAddCommand()
    {
        $client = static::createClient(
//            array(),
//            array(
//                'HTTP_HOST' => 'my.server.location',
//            )
        );

        $crawler = $client->request('GET', '/admin/command/add');

        dump($crawler->html());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_command[quantity]'] = 10;
        $form['appbundle_command[price]'] = 30;
        $form['appbundle_command[etablishment]'] = 'ShiniGamiLaser';
        $client->submit($form);
        $client->followRedirect();

        echo $client->getResponse()->getContent();
    }

}