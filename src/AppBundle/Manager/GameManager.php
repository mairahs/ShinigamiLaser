<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 28/11/2017
 * Time: 16:29.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class GameManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function joinGame($id_game, $id_card)
    {
        $score = new Score();
        $game = $this->entityManager->getRepository('AppBundle:Game')->find($id_game);
        $card = $this->entityManager->getRepository('AppBundle:Card')->find($id_card);
        $score->setResult(0)
            ->setGames($game)
            ->setCards($card)
            ->setTeam(0);
        $this->entityManager->persist($score);
        $this->entityManager->flush();
    }

    public function unjoinGame($id_game, $id_card)
    {
        $score = $this->entityManager->getRepository('AppBundle:Score')->findOneBy([
            'games' => $id_game,
            'cards' => $id_card,
        ]);
        $this->entityManager->remove($score);
        $this->entityManager->flush();
    }

    public function getCard()
    {
        $player = $this->tokenStorage->getToken()->getUser();
        $cards = null;
        if($player instanceof Player){
            $cards = $this->entityManager->getRepository('AppBundle:Card')->getListCard($player);
        }
        return $cards;
    }

    public function hasCard(Game $game){
        $player = $this->tokenStorage->getToken()->getUser();
        $cards = null;
        if($player instanceof Player){
            $cards = $this->entityManager->getRepository('AppBundle:Card')->hasCard($player, $game);
        }
        return count($cards) > 0;
    }
}
