<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function getOneGameWithScoreAndPlayer($id)
    {
        $queryBuilder = $this->createQueryBuilder('g')
                             ->leftJoin('g.score', 's')
                             ->leftJoin('s.cards', 'c')
                             ->leftJoin('c.player', 'p')
                             ->addSelect('p')
                             ->addSelect('c')
                             ->addSelect('s')
                             ->where('g.id = :id')
                             ->setParameters(['id' => $id])
                             ->orderBy('s.result', 'DESC');

        return $queryBuilder->getQuery()->getSingleResult();
    }

    /**
     * @return array
     */
    public function findAllGamesWithoutScore()
    {
        $queryBuilder = $this->createQueryBuilder('g')
                                         ->leftJoin('g.score', 's')
                                         ->addSelect('s')
                                         ->where('s.id IS NULL');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $player
     * @return array
     */
    public function findAllBookableGame($player)
    {
        $qb = $this->createQueryBuilder('game');
        $qb
            ->select('DISTINCT(game.id)')
            ->join('game.score', 'score')
            ->join('score.cards', 'cards')
            ->andWhere("game.booking = '1' AND cards.player = :player")
            ->setParameters([
                'player' => $player,
            ]);

        $array_game_booked = $qb->getQuery()->getResult();
        $array_id_booked = array_map(function ($a) {
            return $a[1];
        }, $array_game_booked);
        ((0 === count($array_id_booked)) ? $array_id_booked = [''] : '');
        $qb = $this->createQueryBuilder('game');
        $qb
            ->select('game')
            ->leftJoin('game.score', 'score')
            ->addSelect('score')
            ->where($qb->expr()->notIn('game.id', $array_id_booked))
            ->andWhere("game.booking = '1'")
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $player
     * @return array
     */
    public function findGameBooked($player)
    {
        $qb = $this->createQueryBuilder('game');
        $qb
            ->select('game AS row')
            ->addSelect('cards.id AS cardId')
            ->join('game.score', 'score')
            ->join('score.cards', 'cards')
            ->andWhere("game.booking = '1' AND cards.player = :player")
            ->setParameters([
                'player' => $player,
            ]);

        return $qb->getQuery()->getResult();
    }



}
