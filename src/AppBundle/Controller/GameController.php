<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 22/11/2017
 * Time: 16:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Score;
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

    public function joinAction($id_game, $id_card)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $game = $entityManager->getRepository('AppBundle:Game')->find($id_game);
        $card = $entityManager->getRepository('AppBundle:Card')->find($id_card);

        $score = new Score();
        $score->setResult(0)
            ->setGames($game)
            ->setCards($card)
            ->setTeam(0);
        $entityManager->persist($score);
        $entityManager->flush();

        $this->addFlash('success', 'Félicitations, tu es bien inscrit pour cette partie');
        return $this->redirectToRoute('user_register');
        {

        }
    }
}
