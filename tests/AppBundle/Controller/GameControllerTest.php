<?php

namespace Tests\AppBundle\Controller;


use AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestBundle\LoginTrait;

class GameControllerTest extends WebTestCase
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

    /** @test */
    public function add()
    {
        $crawler = $this->client->request('GET', '/admin/game/add');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Enregistrer une nouvelle partie', $crawler->filter('h4')->text());

        $nodeButton = $crawler->selectButton('Ajouter');

        $gameType = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:GameType')->findAll([], [], 1);
        $timeSlot = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:TimeSlot')->findAll([], [], 1);
        $etablishment = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Etablishment')->findAll([], [], 1);

        $form = $nodeButton->form();
        $form['appbundle_game[playedAt]'] = "20/12/2017";
        $form['appbundle_game[gameType]']->select($gameType[0]->getId());
        $form['appbundle_game[timeSlot]']->select($timeSlot[0]->getId());
        $form['appbundle_game[etablishment]']->select($etablishment[0]->getId());
        $form['appbundle_game[nbMax]'] = 10;

        $this->client->submit($form);
        $crawler_game = $this->client->followRedirect();

        $this->assertSame($etablishment[0]->getName(), $crawler_game->filter('h4.card-title')->eq(0)->text());
        $this->assertSame('20/12/2017', $crawler_game->filter('h4.card-title')->eq(1)->text());
        $this->assertSame('0 / 10', $crawler_game->filter('h4.card-title')->eq(2)->text());
        $this->assertSame($gameType[0]->getType(), $crawler_game->filter('h4.card-title')->eq(3)->text());
        $this->assertSame($timeSlot[0]->getType(), $crawler_game->filter('h4.card-title')->eq(4)->text());
        $this->assertSame($etablishment[0]->getCity(), $crawler_game->filter('p.medium-small.grey-text')->text());
        $this->assertSame("Il n'y a pas encore de joueur", $crawler_game->filter('td[colspan="4"]')->text());
    }

    /** @test */
    public function show()
    {
        /** @var Game $game */
        $game = $this->client->getContainer()->get('doctrine')->getRepository('AppBundle:Game')->findAll([], [], 1);
        $crawler = $this->client->request('GET', '/game/'.$game[0]->getId());

        $this->assertSame($game[0]->getEtablishment()->getName(), $crawler->filter('h4.card-title')->eq(0)->text());
        $this->assertSame($game[0]->getPlayedAt()->format('d/m/Y'), $crawler->filter('h4.card-title')->eq(1)->text());
        $this->assertSame(strval(count($game[0]->getScore())), $crawler->filter('h4.card-title')->eq(2)->text());
        $this->assertSame($game[0]->getGameType()->getType(), $crawler->filter('h4.card-title')->eq(3)->text());
        $this->assertSame($game[0]->getTimeSlot()->getType(), $crawler->filter('h4.card-title')->eq(4)->text());
        $this->assertSame($game[0]->getEtablishment()->getCity(), $crawler->filter('p.medium-small.grey-text')->text());
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }
}