<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * HolidayRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class HolidayRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\Holiday $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\Holiday $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

