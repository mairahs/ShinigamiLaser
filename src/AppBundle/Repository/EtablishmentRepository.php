<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EtablishmentRepository extends EntityRepository
{
    public function getAllEtablishmentsWithGames()
    {
        $queryBuilder = $this->createQueryBuilder('e')
                             ->leftJoin('e.games','g')
                             ->addSelect('g');

        return $queryBuilder->getQuery()
                            ->getResult();
    }
}
