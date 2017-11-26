<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;


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
        return $queryBuilder->getQuery()
            ->getSingleResult();
    }

    public function findAllGamesWithoutScore()
    {
        $queryBuilder = $this->createQueryBuilder('g')
                                         ->leftJoin('g.score','s')
                                         ->addSelect('s')
                                         ->where('s.id IS NULL');
        return $queryBuilder->getQuery()
                                        ->getResult();

    }
}
