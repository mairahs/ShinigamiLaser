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
}