<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Search a player by his number card
     * @param Request $request
     *
     * @return Response
     */
    public function findAction(Request $request)
    {
        $numberCard = $request->request->get('number_card');
        if ('POST' === $request->getMethod() && !is_null($numberCard) && '' !== $numberCard) {
            try {
                $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findPlayerByNumberCard($numberCard);

                return $this->redirectToRoute('app_dashboard_show', ['id' => $player->getId()]);
            } catch (\Exception $exception) {
                $this->addFlash('notice', 'Aucun joueur ne possède ce numéro de carte');
            }
        }

        return $this->render('@Admin/user/find_player.html.twig');
    }
}
