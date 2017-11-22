<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        /** @var Player $player */
        $player = $this->get('security.token_storage')->getToken()->getUser();
        $cards = $this->getDoctrine()->getRepository('AppBundle:Score')->getListCardDashboard($player);
        return $this->render('default/dashboard.html.twig', [
            'cards' => $cards
        ]);
    }
}
