<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SpecificScheduleRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class SpecificScheduleRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\SpecificSchedule $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\SpecificSchedule $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

