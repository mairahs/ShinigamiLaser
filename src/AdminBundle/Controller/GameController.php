<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Manager\CardManager;
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

            return $this->redirectToRoute('admin_game_show', array('id' => $game->getId()));
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

   public function user_showAction($id)
   {
       $player = $this->getDoctrine()->getManager()->getRepository('AppBundle:Player')->find($id);
       $ret = $this->get(CardManager::class)->returnDashboard($player);
       return $this->render('default/dashboard.html.twig', $ret);
   }

}