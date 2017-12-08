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
        $form['appbundle_command[etablishment]']->select(1);
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('li.green-text')->count());
    }

    public function testShowCommand()
    {

        $crawler = $this->client->request('GET', 'command/show/1');

//        dump($crawler->html());

    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
    }

}