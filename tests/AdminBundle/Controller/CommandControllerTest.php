<?php

namespace Tests\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\TestBundle\LoginTrait;

class CommandControllerTest extends WebTestCase
{
    use LoginTrait;

    /** @var  Client */
    private $client;

    public function setUp()
    {
        $this->client = $this->logIn();

//        $em = $this->client->getContainer()->get('doctrine')->getManager();
//        $admin = new Admin();
//        $admin->setPassword('test');$admin->setEmail('test@test.fr');$admin->setUsername('test');
//        $em->persist($admin);
//        $em->flush();
    }

    public function testAddCommand()
    {
        $crawler = $this->client->request('GET', '/admin/dashboard');

        $link = $crawler
            ->filter('a:contains("Commander des cartes de fidélité")')
            ->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_command[quantity]'] = 10;
        $form['appbundle_command[price]'] = 30;
        $form['appbundle_command[etablishment]']->select('1');
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        echo $this->client->getResponse()->getContent();

        $this->assertSame(1, $crawler->filter('li.green-text')->count());

    }

}