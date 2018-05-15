<?php

namespace ZfMetal\Restful\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Indaxia\OTR\Traits\Transformable;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ZfMetal\Restful\Filter\Builder;
use ZfMetal\Restful\Filter\DoctrineQueryBuilderFilter;
use ZfMetal\Restful\Options\ModuleOptions;

/**
 * MainController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class MainController extends AbstractRestfulController
{

    const CONTENT_TYPE_JSON = 'json';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return ModuleOptions
     */
    public function getOptions()
    {
        return $this->zfMetalRestfulOptions();
    }


    /**
     * @return \Doctrine\ORM\EntityRepository
     * @throws \Exception
     */
    public function getEntityRepository()
    {
        $entityAlias = $this->params("entityAlias");

        if (key_exists($entityAlias, $this->getOptions()->getEntityAliases())) {
            $entityName = $this->getOptions()->getEntityAliases()[$entityAlias];
        } else {
            throw new \Exception("EntityAlias is not defined in config");
        }

        if ($entityName) {
            return $this->getEm()->getRepository($entityName);
        } else {
            throw new \Exception("EntityName is Null");
        }
    }

    protected function findAll()
    {
        //$data= $this->getEntityRepository()->findAll();

        $qb = $this->getEntityRepository()->createQueryBuilder('u');

        $data = $qb->select('u')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $data;
    }


    protected function filterQuery($query)
    {

        $qb = $this->getEntityRepository()->createQueryBuilder('u')->select('u');

        $builder = new Builder($query, Builder::TYPE_SIMPLE);
        $builder->build();

        $DoctrineQueryBuilderFilter = new DoctrineQueryBuilderFilter($qb, $builder->getFilters());
        $qb = $DoctrineQueryBuilderFilter->applyFilters();


        return $qb->getQuery()->getResult();
    }

    /**
     * Return list of resources
     *
     * @return array
     */
    public function get($id = null)
    {
        try {
            $query = $this->getRequest()->getQuery();

            $objects = $this->filterQuery($query);

            $results = Transformable::toArrays($objects);

            return new JsonModel($results);

        } catch (\Exception $e) {
            $a = [
                "messages" => $e->getMessage()
            ];
            return new JsonModel($a);
        }
    }


}

