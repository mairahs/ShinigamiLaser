<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 28/11/2017
 * Time: 16:29.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;

class GameManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
}