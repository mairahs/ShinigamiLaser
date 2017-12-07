<?php

namespace AppBundle\Repository;

class CommandRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findAllCommandsWithEtablishment()
    {
        $queryBuilder = $this->createQueryBuilder('c')
                             ->leftJoin('c.etablishment', 'e')
                             ->addSelect('e')
                             ->orderBy('c.dateOfOrder', 'DESC');

        return $queryBuilder->getQuery()
                     ->getResult();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOneCommandWithEtablishment($id)
    {
        $queryBuilder = $this->createQueryBuilder('c')
                             ->leftJoin('c.etablishment', 'e')
                             ->leftJoin('c.cards', 'cards')
                             ->addSelect('e')
                             ->addSelect('cards')
                             ->where('c.id = :id')
                             ->setParameters(['id' => $id]);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOneCommandWithCards($id)
    {
        $queryBuilder = $this->createQueryBuilder('co')
                             ->leftJoin('co.cards', 'ca')
                             ->addSelect('ca')
                             ->where('co.id =:id')
                             ->setParameters(['id' => $id]);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
