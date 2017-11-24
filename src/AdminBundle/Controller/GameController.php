<?php


namespace AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
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
       $cards = $this->getDoctrine()->getRepository('AppBundle:Score')->getListCardDashboard($player);
       return $this->render('default/dashboard.html.twig', [
           'cards' => $cards
       ]);
   }
}