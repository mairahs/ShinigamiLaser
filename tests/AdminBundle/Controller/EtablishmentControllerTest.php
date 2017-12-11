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
        $crawler = $this->client->request('GET', 'etablishments');

        $this->assertSame(1, $crawler->filter('html:contains("Liste des établissements ShinigamiLaser")')->count());
        $this->assertSame(1, $crawler->filter('html:contains(" Retour à l\'interface d\'administration")')->count());
        $this->assertSame('ShinigamiLaser - ETABLISHMENT1', $crawler->filter('td')->eq(0)->text());
        $this->assertSame('123', $crawler->filter('td')->eq(1)->text());
        $this->assertSame('ville', $crawler->filter('td')->eq(2)->text());
    }

    public function testShowEtablishment()
    {
        $crawler = $this->client->request('GET', 'etablishment/1');

        $this->assertSame('SL - etablishment1', $crawler->filter('h4.card-title')->eq(0)->text());
        $this->assertSame(1, $crawler->filter('html:contains("Retour vers la liste des établissements")')->count());
        $this->assertSame('ville', $crawler->filter('h4.card-title')->eq(1)->text());
        $this->assertSame('123', $crawler->filter('h4.card-title')->eq(2)->text());


    }
    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
    }

}