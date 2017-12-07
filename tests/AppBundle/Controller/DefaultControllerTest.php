<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
//    /** @test */
//    public function show_dashboard_other(){
//        $client = static::createClient();
//
//
//        $container = $client->getContainer();
//
//        $em = $container->get('doctrine')->getManager();
//
//
//        $player = new Player();
//        $player->setUsername('username');
//        $player->setPhoneNumber('06000000');
//        $player->setPassword('test');
//        $player->setEmail('toto@toto.fr');
//        $player->setDateOfBirth(new \DateTime());
//        $player->setAddress('3 rue saint lazare');
//        $player->setLastname('lastname');
//        $player->setFirstname('firstname');
//        $player->setIsActivate(1);
//        $player->setToken('12zz22');
//
//        $em->persist($player);
//
//
//        $em->flush();
//
//        $crawler = $client->request('GET', '/dashboard');
//        $crawler->l
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSecuredHello()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/dashboard');

        dump($crawler->html());

//        $this->assertTrue($this->client->getResponse()->isSuccessful());
//        $this->assertGreaterThan(0, $crawler->filter('html:contains("Admin Dashboard")')->count());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'admin_main';

        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
