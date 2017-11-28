<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PlayerRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends EntityRepository
{
    public function findPlayerByNumberCard($numberCard)
    {
        $queryBuilder = $this->createQueryBuilder('p')
                                          ->leftJoin('p.cards', 'c')
                                          ->addSelect('c')
                                          ->where('c.number = :numberCard')
                                         ->setParameters(['numberCard' => $numberCard]);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
