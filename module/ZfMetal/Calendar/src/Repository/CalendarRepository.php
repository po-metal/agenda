<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CalendarRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Calendar $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Calendar $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

