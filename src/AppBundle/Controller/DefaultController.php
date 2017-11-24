<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Manager\CardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        /** @var Player $player */
        $player = $this->get('security.token_storage')->getToken()->getUser();
        $ret = $this->get(CardManager::class)->returnDashboard($player);
        return $this->render('default/dashboard.html.twig', $ret);
    }
}
