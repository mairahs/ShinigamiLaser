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
            ->leftJoin('etablishment.commands', 'commands')
            ->leftJoin('commands.cards', 'cards')
            ->leftJoin('cards.player','player')
            ->addSelect('commands')
            ->addSelect('cards')
            ->addSelect('player')
            ->where("cards.status = 'active'");

        return $queryBuilder->getQuery()->getResult();
    }

    public function  findAllEtablishmentsWithBookingFalse()
    {
        $queryBuilder = $this->createQueryBuilder('etablishment')
                             ->leftJoin('etablishment.games','game')
                             ->addSelect('game')
                             ->where('game.booking = 0')
                             ->orderBy('game.playedAt', 'DESC');

        return $queryBuilder->getQuery()->getResult();

    }

    public function findAllEtablishmentsWithBookingTrue()
    {
        $queryBuilder = $this->createQueryBuilder('etablishment')
            ->leftJoin('etablishment.games','game')
            ->leftJoin('game.score','score')
            ->leftJoin('score.cards','card')
            ->addSelect('game')
            ->addSelect('score')
            ->addSelect('card')
            ->where('game.booking = 1')
            ->orderBy('game.playedAt', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

}
