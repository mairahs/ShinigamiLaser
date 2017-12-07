<?php


namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /** @test */
    public function login_admin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');

        $nodeButton = $crawler->selectButton('Connexion');

        $form = $nodeButton->form();
        $form['_username'] = 'test';
        $form['_password'] = 'test';

        $client->submit($form);
        $client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('Bienvenue test', $client->getCrawler()->filter('p')->text());
    }

    /** @test */
    public function login_admin_error()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');

        $nodeButton = $crawler->selectButton('Connexion');

        $form = $nodeButton->form();
        $form['_username'] = 'test';
        $form['_password'] = 'testfaux';

        $client->submit($form);
        $r_crawler = $client->followRedirect();

        $this->assertSame('Identifiants invalides.', $r_crawler->filter('div.red-text')->text());
    }
}