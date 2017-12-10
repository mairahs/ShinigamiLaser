<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 10/12/2017
 * Time: 16:40
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestBundle\LoginTrait;

class CardControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = $this->logIn('player');
    }

    /** @test */
    public function add()
    {
        $crawler = $this->client->request('GET', '/card/add');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Ajouter une nouvelle carte', $crawler->filter('h4')->text());

        $card = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Card')->findBy(['status' => 'in_store'], [], 1);

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_card[number]'] = $card[0]->getNumber();

        $this->client->submit($form);
        $crawler_redirect = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler_redirect->filter('a[href="/card/show/'.$card[0]->getId().'"]')->count());
    }

    /** @test */
    public function disable()
    {
        $user = $this->client->getContainer()->get('security.token_storage')->getToken()->getUser();
        $card = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Card')->findBy(['status' => 'active', 'player' => $user], [], 1);
        $crawler = $this->client->request('GET', '/card/disable/'.$card[0]->getId());
        $this->assertSame("Carte perdue ou volée", $crawler->filter('h4')->text());

        $form = $crawler->selectButton('Desactiver la carte')->form();
        $this->client->submit($form);

        $crawler_redirect = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler_redirect->filter('a[href="/card/show/'.$card[0]->getId().'"]')->parents('td')->children('div[title="carte desactivée"]')->count());
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }
}