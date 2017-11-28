<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Manager\GameManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
    public function addAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations, votre partie a bien été créée');

            return $this->redirectToRoute('app_game_show', array('id' => $game->getId()));
        }

        return $this->render('@Admin/game/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function showAction($id)
    {
        $game = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->getOneGameWithScoreAndPlayer($id);
        if (null == $game) {
            new notFoundHttpException('La partie demandée n\'existe pas');
        }

        return $this->render('AdminBundle:game:show.html.twig', ['game' => $game]);
    }

    public function joinAction($id_game, $id_card)
    {
        $this->get(GameManager::class)->joinGame($id_game, $id_card);

        return $this->redirectToRoute('app_dashboard');
    }

    public function unjoinAction($id_game, $id_card)
    {
        $this->get(GameManager::class)->unjoinGame($id_game, $id_card);

        return $this->redirectToRoute('app_dashboard');
    }
}
