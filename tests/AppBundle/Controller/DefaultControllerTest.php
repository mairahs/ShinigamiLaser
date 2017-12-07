<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestBundle\LoginTrait;

class DefaultControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;


    public function setUp()
    {
        $this->client = $this->logIn();
    }

    public function testSecuredHello()
    {
        $crawler = $this->client->request('GET', '/admin/dashboard');


        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
//        $this->assertSame('Admin Dashboard', $crawler->filter('h1')->text());
    }

    protected function tearDown()
    {
        $this->client = null;
    }
}