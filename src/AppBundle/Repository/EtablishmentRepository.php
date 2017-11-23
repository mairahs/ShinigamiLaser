<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EtablishmentRepository extends EntityRepository
{
    public function getAllEtablishmentsWithGames()
    {
        $queryBuilder = $this->createQueryBuilder('e')
                             ->leftJoin('e.games', 'g')
                             ->addSelect('g');

        return $queryBuilder->getQuery()
                            ->getResult();
    }

    public function getOneEtablishmentWithGamesAndScores($id)
    {
        $queryBuilder = $this->createQueryBuilder('e')
                                        ->leftJoin('e.games', 'g')
                                        ->addSelect('g')
                                        ->leftJoin('g.score', 's')
                                        ->addSelect('s')
                                        ->where('e.id = :id')
                                        ->setParameters(['id'=>$id]);
        return $queryBuilder->getQuery()
            ->getSingleResult();
    }
}
