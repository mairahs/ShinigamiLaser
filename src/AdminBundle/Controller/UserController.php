<?php


namespace AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function  findAction(Request $request)
    {
      $numberCard = $request->request->get('number_card');
        if ($request->getMethod() === "POST" && !is_null($numberCard) && $numberCard !== "")
        {
            $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findPlayerByNumberCard($numberCard);
            if(!$player)
            {
                throw new AccessDeniedException('Aucun joueur ne possède ce numéro de carte');
            }
        }
            return  $this->render('@Admin/user/find_player.html.twig');
    }
}