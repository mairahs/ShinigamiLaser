<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Service\CardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        /** @var Player $player */
        $player = $this->get('security.token_storage')->getToken()->getUser();
        $cards = $this->getDoctrine()->getRepository('AppBundle:Score')->getListCardDashboard($player);
        $stats = $this->get(CardManager::class)->getStatsDashboard($cards);
        return $this->render('default/dashboard.html.twig', [
            'player' => $player,
            'cards' => $cards,
            'stats' => $stats
        ]);
    }
}
