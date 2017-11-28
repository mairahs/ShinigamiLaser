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

    public function getPlayersByEtablishment()
    {
        $queryBuilder = $this->createQueryBuilder('etablishment')
            ->leftJoin('etablishment.cards', 'cards')
            ->leftJoin('cards.player', 'player')
            ->addSelect('etablishment')
            ->addSelect('cards')
            ->addSelect('player');

        return $queryBuilder->getQuery()->getResult();
    }
}
