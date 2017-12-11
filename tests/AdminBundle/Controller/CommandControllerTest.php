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

        $etablishments = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Etablishment')->findBy([],[],1);

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_command[quantity]'] = 2;
        $form['appbundle_command[price]'] = 30;
        $form['appbundle_command[etablishment]']->select($etablishments[0]->getId());
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('li.green-text')->count());
    }

    public function testIndexCommand()
    {
        $crawler = $this->client->request('GET', 'commands');

        $this->assertSame(1, $crawler->filter('html:contains("Liste des commandes de carte de fidélité par établissement ShinigamiLaser")')->count());

        $this->assertSame('2', $crawler->filter('td')->eq(0)->text());
        $this->assertSame('2', $crawler->filter('td')->eq(0)->text());
        $this->assertSame('30 €', $crawler->filter('td')->eq(1)->text());
        $this->assertSame((new \DateTime())->format('d/m/Y'), $crawler->filter('td')->eq(2)->text());
    }
    public function testShowCommand()
    {
        $commands = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Command')->findBy([],[],1);

        $crawler = $this->client->request('GET', 'command/show/'.$commands[0]->getId());

        $this->assertSame($commands[0]->getDateOfOrder()->format('d/m/Y'), $crawler->filter('h4.card-title')->eq(0)->text());
        $this->assertSame(strval($commands[0]->getQuantity()), $crawler->filter('h4.card-title')->eq(1)->text());
        $this->assertSame(strval($commands[0]->getPrice()). ' €', $crawler->filter('h4.card-title')->eq(2)->text());
        $this->assertSame($commands[0]->getEtablishment()->getName(), $crawler->filter('h4.card-title')->eq(3)->text());
        $this->assertSame(1, $crawler->filter('html:contains("Retour vers la liste des commandes")')->count());

    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
    }

}