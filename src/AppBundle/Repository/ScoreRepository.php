<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Card;
use AppBundle\Entity\Player;

/**
 * ScoreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScoreRepository extends \Doctrine\ORM\EntityRepository
{
    public function getListCardDashboard(Player $player)
    {
        $queryBuilder = $this  ->createQueryBuilder('score')
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

    public function getStatsGame(Card $card)
    {
        $queryBuilder = $this  ->createQueryBuilder('score')
            ->leftJoin('score.games', 'games')
            ->select('score.result, score.rank, score.team')
            ->addSelect('games.playedAt')
            ->addSelect('games.type')
            ->andWhere('score.cards = :card')
            ->setParameters([
                'card' => $card
            ]);
        return $queryBuilder->getQuery()->getResult();
    }
}
