<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Manager\DashboardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        /** @var Player $player */
        $player = $this->get('security.token_storage')->getToken()->getUser();
        $ret = $this->get(DashboardManager::class)->returnDashboard($player);

        return $this->render('default/dashboard.html.twig', $ret);
    }

    public function showAction($id)
    {
        $player = $this->getDoctrine()->getManager()->getRepository('AppBundle:Player')->find($id);
        $ret = $this->get(DashboardManager::class)->returnDashboard($player);

        return $this->render('default/dashboard.html.twig', $ret);
    }
}
