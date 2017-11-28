<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Player;
use Doctrine\ORM\EntityRepository;

/**
 * PlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends EntityRepository
{
    public function findPlayerByNumberCard($numberCard)
    {
        $queryBuilder = $this  ->createQueryBuilder('p')
                                          ->leftJoin('p.cards', 'c')
                                          ->addSelect('c')
                                          ->where('c.number = :numberCard')
                                         ->setParameters(['numberCard'=>$numberCard]);
        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function findAllPlayersByEtablishment($etablishment)
    {
        $queryBuilder = $this  ->createQueryBuilder('p')
                               ->leftJoin('p.cards','c')
                               ->addSelect('c')
                               ->leftJoin('c.etablishment', 'e')
                               ->addSelect('e')
                               ->where('e.id = :etablishment')
                               ->setParameters(['etablishment'=>$etablishment]);
        return $queryBuilder->getQuery()->getResult();
    }


}
