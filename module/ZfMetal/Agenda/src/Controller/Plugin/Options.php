<?php

namespace ZfMetal\Agenda\Controller\Plugin;

/**
 * Options
 *
 * @author
 * @license
 * @link
 */
class Options extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{

    private $moduleOptions = null;

    public function __construct(\ZfMetal\Agenda\Options\ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function __invoke()
    {
        return $this->moduleOptions;
    }


}

