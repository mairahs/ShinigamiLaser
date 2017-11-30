<?php

namespace AppBundle\Repository;

class CommandRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllCommandsWithEtablishment()
    {
        $queryBuilder = $this->createQueryBuilder('c')
                             ->leftJoin('c.etablishment','e')
                             ->addSelect('e');
        return $queryBuilder->getQuery()
                     ->getResult();
    }
}
