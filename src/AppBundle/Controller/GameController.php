<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 22/11/2017
 * Time: 16:34
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function indexAction()
    {
        $games = $this->getDoctrine()->getRepository('AppBundle:Score')->findAll();
        return $this->render('game/game.index.html.twig', [
            'games' => $games
        ]);
    }

    public function showAction()
    {
        $games = $this->getDoctrine()->getRepository('AppBundle:Score')->findAll();
        return $this->render('game/game.index.html.twig', [
            'games' => $games
        ]);
    }
}
