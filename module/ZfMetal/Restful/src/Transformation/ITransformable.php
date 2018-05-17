<?php
namespace ZfMetal\Restful\Transformation;

use \Doctrine\ORM\EntityManagerInterface;
use \Doctrine\Common\Annotations\Reader;
use  ZfMetal\Restful\Transformation\Exceptions\Exception;
use  ZfMetal\Restful\Transformation\Annotations\PolicyResolver;
use  ZfMetal\Restful\Transformation\Annotations\Policy;

/** Provides JSON-ready Doctrine ORM Entity-Array transfomtaions */
interface ITransformable { 
    
    /** Converts Entity and it's references to nested array structure.
     *  @param Policy\Interfaces\Policy|null transfromation policy, null equals to Policy\Auto
     *  @param Reader $ar for internal recursive purposes
     *  @param PolicyResolver $pr for internal recursive purposes
     *  @return array ready for JSON serialization.
     *  @see readme.md
     *  @throws Exception when input type or policy aren't acceptable
     *  It excludes any static values.
    */
    public function toArray(
        Policy\Interfaces\Policy $policy = null,
        Reader $ar = null,
        PolicyResolver $pr = null
    );

    
    /** Applies toArray to multiple entities.
     * @param array $entities array of entities
     * @param array $policy
     * @param Reader $ar for internal recursive purposes
     * @param PolicyResolver $pr for internal recursive purposes
     * @return array
     * @see ITransformable::toArray */
    public static function toArrays(
        array $entities,
        Policy\Interfaces\Policy $policy = null,
        Reader $ar = null,
        PolicyResolver $pr = null
    );
}