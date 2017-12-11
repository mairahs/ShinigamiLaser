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

    public function testIndexCommand()
    {
        $crawler = $this->client->request('GET', 'commands');

        $this->assertSame(1, $crawler->filter('html:contains("Liste des commandes de carte de fidélité par établissement ShinigamiLaser")')->count());
        $this->assertSame('10', $crawler->filter('td')->eq(0)->text());
        $this->assertSame('30 €', $crawler->filter('td')->eq(1)->text());
        $this->assertSame('10/12/2017', $crawler->filter('td')->eq(2)->text());
    }
    public function testShowCommand()
    {
        $crawler = $this->client->request('GET', 'command/show/1');

        $this->assertSame(' 08/12/2017', $crawler->filter('h4.card-title')->eq(0)->text());
        $this->assertSame('2', $crawler->filter('h4.card-title')->eq(1)->text());
        $this->assertSame('20 €', $crawler->filter('h4.card-title')->eq(2)->text());
        $this->assertSame('etablishment1', $crawler->filter('h4.card-title')->eq(3)->text());
        $this->assertSame(1, $crawler->filter('html:contains("Retour vers la liste des commandes")')->count());

    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
    }

}