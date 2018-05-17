<?php
namespace ZfMetal\Restful\Transformation\Annotations\Policy\Interfaces;
interface Custom extends Policy {
    public function format(\Closure $handler);
    public function transform(\Closure $handler);
}