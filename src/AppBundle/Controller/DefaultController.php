<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Manager\DashboardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * provide dashboard to one connected player.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        /** @var Player $player */
        $player = $this->get('security.token_storage')->getToken()->getUser();
        $ret = $this->get(DashboardManager::class)->returnDashboard($player);

        return $this->render('default/dashboard.html.twig', $ret);
    }

    /**
     * provide dashboard to another player.
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $player = $this->getDoctrine()->getManager()->getRepository('AppBundle:Player')->find($id);
        $ret = $this->get(DashboardManager::class)->returnDashboard($player);
        $ret['other'] = true;

        return $this->render('default/dashboard.html.twig', $ret);
    }
}
