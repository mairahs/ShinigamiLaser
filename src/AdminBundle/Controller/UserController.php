<?php

namespace AdminBundle\Controller;

use AppBundle\Manager\DashboardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
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
                $ret = $this->get(DashboardManager::class)->returnDashboard($player);

                return $this->render('default/dashboard.html.twig', $ret);
            } catch (\Exception $exception) {
                $this->addFlash('notice', 'Aucun joueur ne possède ce numéro de carte');
            }
        }

        return $this->render('@Admin/user/find_player.html.twig');
    }
}
