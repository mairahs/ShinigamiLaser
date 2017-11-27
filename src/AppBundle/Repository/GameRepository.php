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
        $qb = $this->createQueryBuilder('game');

        $nots = $qb->select('card')
            ->from('AppBundle:Card', 'card')
            ->where($qb->expr()->eq('card.id',87))
            ->getQuery()
            ->getResult();


        dump($nots);


        $qb->select('game')
            ->leftJoin('game.score','score')
//            ->leftJoin('game.score','score')
            ->select('score')
            ->where($qb->expr()->notLike('score.cards', $nots))
        ;

        dump($qb->getQuery()->getDQL());
        die;

        return $queryBuilder->getQuery()->getResult();
    }
}
