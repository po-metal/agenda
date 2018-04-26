<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ActivityRangeRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ActivityRangeRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\ActivityRange $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\ActivityRange $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

