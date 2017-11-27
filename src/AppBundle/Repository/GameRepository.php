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

    public function findAllBookableGame($tab_id_card)
    {
//        $qb = $this->createQueryBuilder('game');
//
//        $nots = $qb->select('card')
//            ->from('AppBundle:Card', 'card')
//            ->where($qb->expr()->eq('card.id',476))
//            ->getQuery()
//            ->getSingleResult();
//
//
//        dump($nots);

//        $qb = $this->createQueryBuilder('game');
//
//        $qb
//            ->leftJoin('game.score','score')
//            ->leftJoin('score.cards','cards')
//            ->select('cards.id')
//            ->where($qb->expr()->in('cards.id', $tab_id_card))
//            ->groupBy('cards.number')
//        ;
//        dump($qb->getQuery()->getResult());

//        dump($qb->getQuery()->getResult());

//        die;

        $qb = $this->createQueryBuilder('game');

        $qb
            ->leftJoin('game.score','score')
            ->leftJoin('score.cards','cards')
//            ->select('cards.id')
            ->addSelect('game.playedAt')
            ->where($qb->expr()->notIn('cards.id', $tab_id_card))
//            ->groupBy('cards.number')
        ;
        dump($qb->getQuery()->getResult());
        die;

        return $qb->getQuery()->getResult();
    }
}
