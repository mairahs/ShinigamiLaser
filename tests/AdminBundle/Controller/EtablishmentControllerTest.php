<?php

namespace Tests\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Tests\TestBundle\LoginTrait;

class EtablishmentControllerTest extends WebTestCase
{
    use LoginTrait;

    /** @var  Client */
    private $client;

    public function setUp()
    {
        $this->client = $this->logIn();
    }

    public function testIndexEtablishment()
    {
        $etablishments = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Etablishment')->findBy([],[],1);

        $crawler = $this->client->request('GET', 'etablishments');

        $this->assertSame(1, $crawler->filter('html:contains("Liste des établissements ShinigamiLaser")')->count());
        $this->assertSame(1, $crawler->filter('html:contains(" Retour à l\'interface d\'administration")')->count());
        $this->assertSame('ShinigamiLaser - '.strtoupper($etablishments[0]->getName()), $crawler->filter('td')->eq(0)->text());
        $this->assertSame(strval($etablishments[0]->getCode()), $crawler->filter('td')->eq(1)->text());
        $this->assertSame($etablishments[0]->getCity(), $crawler->filter('td')->eq(2)->text());
    }

    public function testShowEtablishment()
    {
        $etablishments = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Etablishment')->findBy([],[],1);

        $crawler = $this->client->request('GET', 'etablishment/'.$etablishments[0]->getId());

        $this->assertSame('SL - '.$etablishments[0]->getName(), $crawler->filter('h4.card-title')->eq(0)->text());
        $this->assertSame(1, $crawler->filter('html:contains("Retour vers la liste des établissements")')->count());
        $this->assertSame($etablishments[0]->getCity(), $crawler->filter('h4.card-title')->eq(1)->text());
        $this->assertSame(strval($etablishments[0]->getCode()), $crawler->filter('h4.card-title')->eq(2)->text());
    }
    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
    }

}