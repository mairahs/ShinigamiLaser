<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Card;
use AppBundle\Entity\GameType;
use AppBundle\Entity\Player;

/**
 * ScoreRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScoreRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Card     $card
     * @param GameType $gameType
     *
     * @return array
     *
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
            ->andWhere("games.booking = '0'")
            ->setParameters([
                'card' => $card,
                'gameType' => $gameType,
            ]);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Card $card
     *
     * @return mixed
     */
    public function getAllStat(Card $card)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('SUM(score.result) AS sumscore')
            ->addSelect('COUNT(score.result) AS nbgames')
            ->andWhere('score.cards = :card')
            ->andWhere("games.booking = '0'")
            ->setParameters([
                'card' => $card,
            ]);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    /**
     * @param Card $card
     * @param $gameType
     *
     * @return mixed
     */
    public function getTypePartie(Card $card, $gameType)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('COUNT(score)')
            ->where('games.gameType = :gameType')
            ->andWhere('score.cards = :card')
            ->andWhere("games.booking = '0'")
            ->setParameters([
                'card' => $card,
                'gameType' => $gameType,
            ]);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param Card $card
     *
     * @return array
     */
    public function getWinlose(Card $card)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->andWhere('score.cards = :card')
            ->andWhere("games.type = 'equipe'")
            ->andWhere("games.booking = '0'")
            ->setParameters([
                'card' => $card,
            ]);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Player $player
     *
     * @return array
     */
    public function getLastGamePlayedPlayer(Player $player)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->leftJoin('score.cards', 'cards')
            ->select('score')
            ->addSelect('games')
            ->where('cards.player = :player')
            ->andWhere("games.booking = '0'")
            ->orderBy('games.playedAt', 'DESC')
            ->setMaxResults(5)
            ->setParameters([
                'player' => $player,
            ]);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Card $card
     *
     * @return array
     */
    public function getLastGamePlayedCard(Card $card)
    {
        $queryBuilder = $this->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->leftJoin('score.cards', 'cards')
            ->select('score')
            ->addSelect('games')
            ->where('cards = :card')
            ->andWhere("games.booking = '0'")
            ->orderBy('games.playedAt', 'DESC')
            ->setMaxResults(5)
            ->setParameters([
                'card' => $card,
            ]);

        return $queryBuilder->getQuery()->getResult();
    }
}
