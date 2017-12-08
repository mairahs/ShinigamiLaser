<?php

namespace Tests\AdminBundle\Controller;


use AppBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\TestBundle\DatabaseTrait;
use Tests\TestBundle\LoginTrait;

class CommandControllerTest extends WebTestCase
{
    use LoginTrait;
    use DatabaseTrait;

    /** @var  Client */
    private $client;
    private $entityManager;

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

    public function testShowCommand()
    {
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $this->generateDatabase($entityManager);

        $crawler = $this->client->request('GET', '/game/1');

    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->rollBack();
        $this->entityManager->close();
        $this->entityManager = null;
        $this->client = null;
    }

}