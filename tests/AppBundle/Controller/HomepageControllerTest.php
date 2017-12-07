<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testHomepageIsDisplayedCorrectly()
    {
        $client = static ::createClient();
        $client->request('GET','/');
        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        echo $response;
    }

    public function testFindH1OnHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/');

        $this->assertSame(1, $crawler->filter('h1')->count());

    }
}