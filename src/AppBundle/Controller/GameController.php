<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 22/11/2017
 * Time: 16:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Entity\Score;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
    public function addAction(Request $request)
    {
        $game = new Game();
        $form   = $this->createForm(GameType::class, $game);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations, votre partie a bien été créée');

            return $this->redirectToRoute('app_game_show', array('id' => $game->getId()));
        }
        return $this->render('@Admin/game/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    public function showAction($id)
    {
        $game = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->getOneGameWithScoreAndPlayer($id);
        if(null == $game)
        {
            new notFoundHttpException('La partie demandée n\'existe pas');
        }
        return $this->render('AdminBundle:game:show.html.twig', ['game'=>$game]);
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
        return $this->redirectToRoute('app_dashboard');
    }

    public function unjoinAction($id_game, $id_card)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $score = $entityManager->getRepository('AppBundle:Score')->findOneBy([
            'games' => $id_game,
            'cards' => $id_card
        ]);
        $entityManager->remove($score);
        $entityManager->flush();
        return $this->redirectToRoute('app_dashboard');
    }
}
