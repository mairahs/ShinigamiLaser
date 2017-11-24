<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Card;
use AppBundle\Entity\GameType;
use AppBundle\Entity\Player;

/**
 * ScoreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScoreRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Player $player
     * @return array
     */
    public function getListCardDashboard(Player $player)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.cards', 'cards')
            ->select('SUM(score.result) AS sumscore')
            ->addSelect('cards.number')
            ->addSelect('cards.id')
            ->addSelect('cards.status')
            ->addSelect('COUNT(score.result) AS nbgames')
            ->groupBy('cards.number')
            ->andWhere('cards.player = :player')
            ->setParameters([
                'player' => $player
            ]);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Card $card
     * @param GameType $gameType
     * @return array
     * @internal param $type
     */
    public function getScoreByGame(Card $card, GameType $gameType)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('score.result')
            ->addSelect('games.playedAt')
            ->where('games.gameType = :gameType')
            ->andWhere('score.cards = :card')
            ->setParameters([
                'card' => $card,
                'gameType' => $gameType
            ]);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Card $card
     * @return mixed
     */
    public function getAllStat(Card $card)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('SUM(score.result) AS sumscore')
            ->addSelect('COUNT(score.result) AS nbgames')
            ->andWhere('score.cards = :card')
            ->setParameters([
                'card' => $card
            ]);
        return $queryBuilder->getQuery()->getScalarResult();
    }

    public function getTypePartie(Card $card){
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('score.result')
            ->addSelect('games.playedAt')
            ->where('games.gameType = :gameType')
            ->andWhere('score.cards = :card')
            ->setParameters([
                'card' => $card,
                'gameType' => $gameType
            ]);
    }

    public function getWinlose(Card $card)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->andWhere('score.cards = :card')
            ->andWhere("games.type = 'equipe'")
            ->setParameters([
                'card' => $card
            ]);
        ;
        dump($queryBuilder->getQuery()->getResult());
        die;
    }
}
