<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 17/5/2018
 * Time: 00:13
 */

namespace ZfMetal\Restful\Transformation;

use \Doctrine\Common\Annotations\Reader;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\CachedReader;
use \Doctrine\Common\Cache\ArrayCache;

class Transform
{
    /**
     * @var Annotations\Policy\Interfaces\Policy
     */
    protected $policy;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var \ZfMetal\Restful\Transformation\Annotations\PolicyResolver
     */
    protected $policyResolver;


    protected $entity;

    /**
     * @var \ReflectionClass
     */
    protected $refClass;

    /**
     * @var array
     */
    protected $properties;

    protected $depth = 1;

    protected $maxDepth;

    const DATE_TYPES = ["date", "time", "datetime", "datetimez"];

    /**
     * Transform constructor.
     * @param $entity
     * @param Annotations\Policy\Interfaces\Policy $policy
     * @param int $maxDepth
     * @param int $depth
     */
    public function __construct($entity, Annotations\Policy\Interfaces\Policy $policy = null, $maxDepth = 2, $depth = 1)
    {
        $this->entity = $entity;
        $this->policy = $policy;
        $this->reader = $this->createCachedReader();
        $this->policyResolver = new PolicyResolver();
        $this->refClass = new \ReflectionClass($this->entity);
        $this->depth = $depth;
        $this->maxDepth = $maxDepth;

    }


    protected function getProperties()
    {
        if (!$this->properties) {
            $this->properties = $this->refClass->getProperties(\ReflectionProperty::IS_PUBLIC
                | \ReflectionProperty::IS_PROTECTED
                | \ReflectionProperty::IS_PRIVATE);
        }
        return $this->properties;
    }


    public function createCachedReader()
    {
        return new CachedReader(new AnnotationReader(), new ArrayCache());
    }


    public function toArray()
    {

        /** @var \ReflectionProperty $property */
        foreach ($this->getProperties() as $property) {

            if ($property->isStatic()) {
                continue;
            }

            $propertyName = $property->getName();

            if ($this->_check($propertyName)) {
                continue;
            }

            $propertyPolicy = $this->policyResolver->resolvePropertyPolicyTo(
                $this->policy, $propertyName, $property, $this->reader);

            if ($propertyPolicy instanceof Annotations\Policy\Interfaces\Skip) {
                continue;
            }

            $result[$propertyName] = $this->toArrayProperty($property, $propertyName, $propertyPolicy);
        }
        return $result;
    }

    protected function _check($propertyName)
    {
        if ($propertyName[0] === '_' && $propertyName[1] === '_') {
            var_dump($propertyName);
            die; //TODO review
            return true;
        }
        return false;
    }


    protected function scalarTypes($property, $propertyName, $getter, $policy)
    {
        $result = null;

        if ($column = $this->reader->getPropertyAnnotation($property, 'Doctrine\ORM\Mapping\Column')) {

            //Value
            $result = $this->entity->$getter();

            //Custom Policy
            if (($policy instanceof Annotations\Policy\Interfaces\Custom) && $policy->format) {
                return call_user_func_array($policy->format, [$result, $column->type]);
            }


            //Date-Time
            if (in_array($column->type, self::DATE_TYPES)) {
                if ($result !== null) {
                    if ($policy instanceof Annotations\Policy\Interfaces\FormatDateTime) {
                        $result = $result->format($policy->format);
                        if ($result === false) {
                            throw new Exceptions\PolicyException('Wrong DateTime format for field "' . $propertyName . '"');
                        }
                    } else if (!$policy instanceof Annotations\Policy\Interfaces\KeepDateTime) {
                        $result = $result->format('Y-m-d\TH:i:s') . '.000Z';
                    }
                }
            }

            if ($column->type == 'simple_array') {
                if ($this->policyResolver->hasOption(PolicyResolver::SIMPLE_ARRAY_FIX)
                    && is_array($result)
                    && (count($result) === 1)
                    && ($result[0] === null)) {
                    return [];
                }
            }
        }
        return $result;
    }

    protected function toArrayProperty($property, $propertyName, $policy, \ReflectionClass $headRefClass)
    {
        $getter = $policy->getter ?: 'get' . ucfirst($propertyName);

        $result = null;

        //SCALAR TYPES
        if ($result = $this->scalarTypes($property, $propertyName, $getter, $policy)) {
        //RELATIONS
        } else if ($association = $this->getPropertyAssociation($property)) { // entity or collection
            $isCollection = false;

            if ($association instanceof OneToMany || $association instanceof ManyToMany) {
                $isCollection = true;
            }

            $relEntity = $this->entity->$getter();

            // ========== COLLECTION RELATION ==========
            if ($isCollection) {
                $collection = $relEntity;
                if ($collection->count()) {
                    if ($policy instanceof Annotations\Policy\Interfaces\FetchPaginateTo) { // pagination policy
                        if ($policy->fromTail) {
                            $offset = $collection->count() - $policy->limit - $policy->offset;
                            if ($offset < 0) {
                                $offset = 0;
                            }
                            $limit = ($collection->count() > $policy->limit) ? $collection->count() : $policy->limit;
                            $collection = $collection->slice($offset, $limit);
                        } else {
                            $collection = $collection->slice($policy->offset, $policy->limit);
                        }
                    }
                    foreach ($collection as $el) {
                        $result['collection'][] = $this->recursiveEntity($el);
                    }
                }

            } else { // single entity
                if ($relEntity) {
                    $result = $this->recursiveEntity($relEntity);
                }
            }

            if (($policy instanceof Annotations\Policy\Interfaces\Custom) && $policy->transform) {
                $result = call_user_func_array($policy->transform, [$relEntity, $result]);
            }

        //NON-DOCTRINE TYPE
        } else {
            $result = $this->$getter();
            if (($policy instanceof Annotations\Policy\Interfaces\Custom) && $policy->format) {
                return call_user_func_array($policy->format, [$result, null]);
            }
        }

        return $result;
    }


    protected function recursiveEntity($relEntity){
        if($this->depth < $this->maxDepth) {
            $transform = new Transform($relEntity, $this->policy, $this->maxDepth, $this->depth + 1);
            return $transform->toArray();
        }
        return null;//TODO Review
    }


    /** @return Annotation|null returns null if its inversed side of bidirectional relation */
    protected function getPropertyAssociation(\ReflectionProperty $property)
    {
        $annotations = $this->reader->getPropertyAnnotations($property);
        foreach ($annotations as $an) {
            if (($an instanceof ManyToOne && !$an->inversedBy)
                || ($an instanceof ManyToMany && !$an->inversedBy)
                || ($an instanceof OneToOne && !$an->inversedBy)
                || $an instanceof OneToMany) {
                return $an;
            }
        }
        return null;
    }

}