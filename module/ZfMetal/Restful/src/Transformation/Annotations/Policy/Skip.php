<?php
namespace Indaxia\OTR\Annotations\Policy;

use \Doctrine\ORM\Mapping as ORM;

/** ITransformable policy.
 * Skips the field in both ITransformabe::fromArray and ITransformabe::toArray.
 * Opposite to Accept.
 * @Annotation */
class Skip 
    extends  ZfMetal\Restful\Transformation\Annotations\Annotation
    implements Interfaces\SkipTo
{        
    public function inside(array $policy) {
        throw new  ZfMetal\Restful\Transformation\Exceptions\PolicyException("Policy\\Skip cannot contain policies");
    }

    public $priority = 0.9;
}