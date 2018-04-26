<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TurnRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TurnRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\Turn $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\Turn $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

