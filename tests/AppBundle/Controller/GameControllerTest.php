<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestBundle\DatabaseTrait;
use Tests\TestBundle\LoginTrait;

class GameControllerTest extends WebTestCase
{
    use LoginTrait;
    use DatabaseTrait;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    private $container;

    private $em;

    public function setUp()
    {
        $this->client = $this->logIn();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    /** @test */
    public function add()
    {
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $this->generateDatabase($em);

        $crawler = $this->client->request('GET', '/admin/game/add');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Enregistrer une nouvelle partie', $crawler->filter('h4')->text());

        $nodeButton = $crawler->selectButton('Ajouter');

        $form = $nodeButton->form();
        $form['appbundle_game[playedAt]'] = "20/12/2017";
        $form['appbundle_game[gameType]']->select(1);
        $form['appbundle_game[timeSlot]']->select(1);
        $form['appbundle_game[etablishment]']->select(1);
        $form['appbundle_game[nbMax]'] = 10;

        $this->client->submit($form);
        $crawler_game = $this->client->followRedirect();

        $this->assertSame('etablishment1', $crawler_game->filter('h4.card-title')->eq(0)->text());
        $this->assertSame('20/12/2017', $crawler_game->filter('h4.card-title')->eq(1)->text());
        $this->assertSame('0 / 10', $crawler_game->filter('h4.card-title')->eq(2)->text());
        $this->assertSame('Team', $crawler_game->filter('h4.card-title')->eq(3)->text());
        $this->assertSame('8h-10h', $crawler_game->filter('h4.card-title')->eq(4)->text());
        $this->assertSame('ville', $crawler_game->filter('p.medium-small.grey-text')->text());
        $this->assertSame("Il n'y a pas encore de joueur", $crawler_game->filter('td[colspan="4"]')->text());
    }

    /** @test */
    public function show()
    {
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $this->generateDatabase($em);

        $crawler = $this->client->request('GET', '/game/1');


//        dump($crawler->html());




    }


    protected function tearDown()
    {
        parent::tearDown();

        $this->em->rollBack();
        $this->em->close();
        $this->em = null;
        $this->client = null;
    }
}