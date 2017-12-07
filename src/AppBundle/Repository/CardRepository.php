<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Etablishment;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;

/**
 * CardRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CardRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Player $player
     *
     * @return array
     */
    public function getListCard(Player $player)
    {
        $queryBuilder = $this->createQueryBuilder('card')
            ->leftJoin('card.score', 'score')
            ->leftJoin('score.games', 'games')
            ->select('SUM(score.result) AS sumscore')
            ->addSelect('card.number')
            ->addSelect('card.id')
            ->addSelect('card.status')
            ->addSelect('COUNT(score.result) AS nbgames')
            ->groupBy('card.number')
            ->where('card.player = :player')
            ->andWhere("(games.id is NULL OR games.booking = '0')")
//            ->orWhere("(games.id is not NULL AND games.booking = '1')")
            ->setParameters([
                'player' => $player,
            ]);
//        dump($queryBuilder->getQuery()->getResult());
//        die;
        return $queryBuilder->getQuery()->getResult();
    }

    public function getListCardByGame(Player $player, Game $game)
    {
        $queryBuilder = $this->createQueryBuilder('card')
            ->leftJoin('card.score', 'score')
            ->leftJoin('score.games', 'games')
            ->select('SUM(score.result) AS sumscore')
            ->addSelect('card.number')
            ->addSelect('card.id')
            ->addSelect('card.status')
            ->addSelect('COUNT(score.result) AS nbgames')
            ->groupBy('card.number')
            ->where('card.player = :player')
            ->andWhere('score.games = :game')
//            ->orWhere("(games.id is not NULL AND games.booking = '1')")
            ->setParameters([
                'player' => $player,
                'game' => $game,
            ]);
//        dump($queryBuilder->getQuery()->getResult());
//        die;
        return $queryBuilder->getQuery()->getResult();
    }

    public function getCountAbonne(Etablishment $etablishment)
    {
        $queryBuilder = $this->createQueryBuilder('card')
            ->join('card.command', 'command')
            ->join('command.etablishment', 'etablishment')
            ->select('COUNT(card.id)')
            ->where('command.etablishment = :etablishment')
            ->andWhere('card.player IS NOT NULL')
            ->setParameter('etablishment', $etablishment)
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function hasCard(Player $player, Game $game)
    {
        $queryBuilder = $this->createQueryBuilder('card')
            ->join('card.score', 'score')
            ->join('score.games', 'games')
            ->select('COUNT(card)')
            ->where('card.player = :player')
            ->andWhere('score.games = :game')
            ->setParameters([
                'player' => $player,
                'game' => $game,
            ])
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function findCardAndPlayerByNumber($card_number)
    {
        $queryBuilder = $this->createQueryBuilder('card')
            ->join('card.player', 'player')
            ->addSelect('player')
            ->where('card.number = :card_number')
            ->setParameters([
                'card_number' => $card_number,
            ])
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
