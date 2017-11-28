<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;


class GameRepository extends EntityRepository
{
    public function getOneGameWithScoreAndPlayer($id)
    {
        $queryBuilder = $this->createQueryBuilder('g')
                             ->leftJoin('g.score','s')
                             ->leftJoin('s.cards','c')
                             ->leftJoin('c.player','p')
                             ->addSelect('p')
                             ->addSelect('c')
                             ->addSelect('s')
                             ->where('g.id = :id')
                             ->setParameters(['id' => $id])
                             ->orderBy('s.result', 'DESC');
        return $queryBuilder->getQuery()->getSingleResult();
    }


    public function findAllGamesWithoutScore()
    {
        $queryBuilder = $this->createQueryBuilder('g')
                                         ->leftJoin('g.score','s')
                                         ->addSelect('s')
                                         ->where('s.id IS NULL');
        return $queryBuilder->getQuery()->getResult();
    }

    public function findAllBookableGame($player)
    {
        $qb = $this->createQueryBuilder('game');
        $qb
            ->select('game.id')
            ->join('game.score', 'score')
            ->join('score.cards', 'cards')
            ->andWhere('cards.player = :player')
            ->setParameters([
                'player' => $player
            ]);
        ;
        $array_game_booked = $qb->getQuery()->getResult();
        $array_id_booked = array_map(function ($a){
            return $a['id'];
        }, $array_game_booked);
        $qb = $this->createQueryBuilder('game');
        $qb
            ->where($qb->expr()->notIn('game.id', $array_id_booked))
            ->andWhere("game.booking = '1'")
        ;
        return $qb->getQuery()->getResult();
    }
}
