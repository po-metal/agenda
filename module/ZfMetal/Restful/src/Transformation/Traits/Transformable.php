<?php
namespace ZfMetal\Restful\Transformation\Traits;

use \Doctrine\Common\Annotations\Reader;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\CachedReader;
use \Doctrine\Common\Cache\ArrayCache;
use \Doctrine\ORM\EntityManagerInterface;
use \Doctrine\ORM\Mapping\ManyToOne;
use \Doctrine\ORM\Mapping\ManyToMany;
use \Doctrine\ORM\Mapping\OneToOne;
use \Doctrine\ORM\Mapping\OneToMany;
use  ZfMetal\Restful\Transformation\Exceptions;
use  ZfMetal\Restful\Transformation\Annotations\Policy;
use  ZfMetal\Restful\Transformation\Annotations\PolicyResolver;

/* Implements Entity Transformations methods
 * @see ITransformable */
trait Transformable {
    
    /** @see ITransformable::toArray()
      * ============================== */
    public function toArray(
        Policy\Interfaces\Policy $policy = null,
        Reader $ar = null,
        PolicyResolver $pr = null
    ) {
        if(!$ar) { $ar = static::createCachedReader(); }
        if(!$pr) { $pr = new PolicyResolver(); }
        $refClass = new \ReflectionClass($this);
        $result = ['__meta' => ['class' => static::getEntityFullName($refClass)]];
        $ps = $refClass->getProperties(  \ReflectionProperty::IS_PUBLIC
                                       | \ReflectionProperty::IS_PROTECTED
                                       | \ReflectionProperty::IS_PRIVATE);
        foreach($ps as $p) {
            if($p->isStatic()) { continue; }
            $pn = $p->getName();
            if($pn[0] === '_' && $pn[1] === '_') { continue; }
            $propertyPolicy = $pr->resolvePropertyPolicyTo($policy, $pn, $p, $ar);
            if($propertyPolicy instanceof Policy\Interfaces\SkipTo) {
                continue;
            }
            $result[$pn] = $this->toArrayProperty($p, $pn, $propertyPolicy, $ar, $pr, $refClass);
        }
        return $result;
    }
    
    
    
    /** ========== PROPERTY (TO) ========== */
    protected function toArrayProperty($p, $pn, $policy, Reader $ar, PolicyResolver $pr, \ReflectionClass $headRefClass) {
        $getter = $policy->getter ?: 'get'.ucfirst($pn);
        $result = null;
        
        // ========== SCALAR TYPES ==========
        if($column = $ar->getPropertyAnnotation($p, 'Doctrine\ORM\Mapping\Column')) { // scalar
            $result = $this->$getter();
            if(($policy instanceof Policy\Interfaces\CustomTo) && $policy->format) {
                return call_user_func_array($policy->format, [$result, $column->type]);
            }
            switch($column->type) {
                case 'simple_array':
                    // @see https://github.com/doctrine/doctrine2/issues/4673
                    if($pr->hasOption(PolicyResolver::SIMPLE_ARRAY_FIX)
                       && is_array($result)
                       && (count($result) === 1)
                       && ($result[0] === null)) {
                        return [];
                    } break;
                case 'date':
                case 'time':
                case 'datetime':
                case 'detetimez':
                    if($result !== null) {
                        if($policy instanceof Policy\Interfaces\FormatDateTimeTo) {
                            $result = $result->format($policy->format);
                            if($result === false) { throw new Exceptions\PolicyException('Wrong DateTime format for field "'.$pn.'"'); }
                        } else if(!$policy instanceof Policy\Interfaces\KeepDateTimeTo) {
                            $result = $result->format('Y-m-d\TH:i:s').'.000Z';
                        }
                    }
                    break;
            }
        
        // ========== RELATIONS ==========
        } else if($association = static::getPropertyAssociation($p, $ar)) { // entity or collection
            $isCollection = false;
            
            if($association instanceof OneToMany) {
                $result = ['__meta' => ['class' => static::getEntityFullName($headRefClass, $association->targetEntity),
                                       'association' => 'OneToMany'], 'collection' => []];
                $isCollection = true;
            } else if($association instanceof ManyToMany) {
                $result = ['__meta' => ['class' => static::getEntityFullName($headRefClass, $association->targetEntity),
                                       'association' => 'ManyToMany'], 'collection' => []];
                $isCollection = true;
            }
            
            $v = $this->$getter();
            
            // ========== COLLECTION RELATION ==========
            if($isCollection) {
                $collection = $v;
                if($collection->count()) {
                    if($policy instanceof Policy\Interfaces\FetchPaginateTo) { // pagination policy
                        if($policy->fromTail) {
                            $offset = $collection->count() - $policy->limit - $policy->offset;
                            if($offset < 0) { $offset = 0; }
                            $limit = ($collection->count() > $policy->limit) ? $collection->count() : $policy->limit;
                            $collection = $collection->slice($offset, $limit);
                        } else {
                            $collection = $collection->slice($policy->offset, $policy->limit);
                        }
                    }
                    foreach($collection as $el) {
                        $result['collection'][] = $el->toArray($policy, $ar, $pr);
                    }
                }
                
            // ========== SUB-ENTITY RELATION ==========
            } else { // single entity
                if($v) { $result = $v->toArray($policy, $ar, $pr); }
            }
            
            if(($policy instanceof Policy\Interfaces\CustomTo) && $policy->transform) {
                $result = call_user_func_array($policy->transform, [$v, $result]);
            }
            
        // ========== NON-DOCTRINE TYPE ==========
        } else {
            $result = $this->$getter();
            if(($policy instanceof Policy\Interfaces\CustomTo) && $policy->format) {
                return call_user_func_array($policy->format, [$result, null]);
            }
        }
        return $result;
    }
    
    

    
    
    /** @see ITransformable::toArrays()
      * =============================== */
    public static function toArrays(
        array $entities,
        Policy\Interfaces\Policy $policy = null,
        Reader $ar = null,
        PolicyResolver $pr = null
    ) {
        if(!$ar) { $ar = static::createCachedReader(); }
        if(!$pr) { $ar = new PolicyResolver(); }
        $arrays = [];
        foreach($entities as $e) { $arrays[] = $e->toArray($policy, null, $ar, $pr); }
        return $arrays;
    }
    
    
    
    
    /* ========== MISC. ========== */
    
    /** @return Annotation|null returns null if its inversed side of bidirectional relation */
    protected static function getPropertyAssociation(\ReflectionProperty $p, Reader $ar) {
        $ans = $ar->getPropertyAnnotations($p);
        foreach($ans as $an) {
            if(($an instanceof ManyToOne && !$an->inversedBy)
               || ($an instanceof ManyToMany && !$an->inversedBy)
               || ($an instanceof OneToOne && !$an->inversedBy)
               || $an instanceof OneToMany) { return $an; }
        }
        return null;
    }
    
    /** Doctrine replaces Entity class with Proxy class, so remove proxy namespace from results. */
    protected static function getEntityFullName(\ReflectionClass $headRefClass, $name = null) {
        if($name && $name[0] !== "\\") {
            $ns = $headRefClass->getNamespaceName();
            if($ns) { 
                $name = $ns."\\".$name; 
            }
        } else {
            $name = $headRefClass->getName();
        }
        if(substr($name, 0, 15) === "Proxies\\__CG__\\") {
            $name = substr($name, 15);
        }
        return $name;        
    }
    
    public static function createCachedReader() {
        return new CachedReader(new AnnotationReader(), new ArrayCache());
    }
}