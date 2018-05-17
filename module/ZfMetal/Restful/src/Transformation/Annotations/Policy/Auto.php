<?php
namespace  ZfMetal\Restful\Transformation\Annotations\Policy;

use \ZfMetal\Restful\Transformation\Annotations\Policy\Interfaces;
use \Doctrine\ORM\Mapping as ORM;

/** ITransformable policy.
 * Automatically decides what to store, it typically uses getter/setter of the field.
 * Global policy: the same behaviour when field isn't specified.
 * Local policy: overrides and ignores all the global policy parameters. 
 * @Annotation */
class Auto
    extends  \ZfMetal\Restful\Transformation\Annotations\Annotation
    implements Interfaces\Auto {

    public $priority = 0.1;
}