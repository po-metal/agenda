<?php
namespace ZfMetal\Restful\Transformation\Annotations\Policy;

use \ZfMetal\Restful\Transformation\Annotations\Policy\Interfaces;
use \Doctrine\ORM\Mapping as ORM;

/** ITransformable policy.
 * Formats datetime according to \DateTime::format schema
 * @see http://php.net/manual/en/function.date.php#refsect1-function.date-parameters
 * Note: ITransformable always works in UTC timezone.
 * @Annotation */
class FormatDateTime
    extends  \ZfMetal\Restful\Transformation\Annotations\Annotation
    implements Interfaces\FormatDateTime {
    public $format = 'r';

    public $priority = 0.2;
    
    public function format($f) { $this->format = $f; return $this; }
}