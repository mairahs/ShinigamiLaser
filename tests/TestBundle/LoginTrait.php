<?php


namespace Tests\TestBundle;


trait LoginTrait
{
    public function logIn($user = "admin")
    {
        $client = static::createClient();

        if("admin" === $user){
            $crawler = $client->request('GET', '/admin/login');
        }else{
            $crawler = $client->request('GET', '/login');
        }

        $nodeButton = $crawler->selectButton('Connexion');

        $form = $nodeButton->form();

        if("admin" === $user){
            $form['_username'] = 'test';
            $form['_password'] = 'test+';
        }else{
            $form['_username'] = 'test';
            $form['_password'] = 'test';
        }

        $client->submit($form);
        $client->followRedirect();

        return $client;
    }
}