<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SpecificRangeRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class SpecificRangeRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\SpecificRange $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\SpecificRange $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

