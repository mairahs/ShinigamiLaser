<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Card;
use AppBundle\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;

class DashboardManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * provide the dashboard of a connected player.
     *
     * @param Player $player
     *
     * @return array
     */
    public function returnDashboard(Player $player)
    {
        $cards = $this->entityManager->getRepository('AppBundle:Card')->getListCard($player);
        $stats = $this->getStatsDashboard($cards);
        $stats['lastGame'] = $this->entityManager->getRepository('AppBundle:Score')->getLastGamePlayedPlayer($player);
        $stats['bookableGame'] = $this->entityManager->getRepository('AppBundle:Game')->findAllBookableGame($player);
        $stats['gameBooked'] = $this->entityManager->getRepository('AppBundle:Game')->findGameBooked($player);

        return[
            'player' => $player,
            'cards' => $cards,
            'stats' => $stats,
        ];
    }

    /**
     * provide stats of game to the dashboard of a connected player.
     *
     * @param $cards
     *
     * @return array
     */
    public function getStatsDashboard($cards)
    {
        /** @var Card $card */
        $scoreTotal = 0;
        $gameTotal = 0;
        foreach ($cards as $card) {
            $scoreTotal += $card['sumscore'];
            $gameTotal += $card['nbgames'];
        }

        return[
            'gameTotal' => $gameTotal,
            'scoreTotal' => $scoreTotal,
        ];
    }
}
