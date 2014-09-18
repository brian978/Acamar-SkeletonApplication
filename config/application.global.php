<?php
/**
 * SlimMVC-SkeletonApplication
 *
 * @link https://github.com/brian978/SlimMVC-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license Creative Commons Attribution-ShareAlike 3.0
 */

return array(
    'baseUri' => '/',
    'modulesPath' => 'module/',
    'independentModules' => false,
    'modules' => array(
        'Application'
    ),
    'errorHandler' => array(
        'route' => array(
            'module' => 'Application',
            'controller' => 'error',
            'action' => 'error'
        )
    )
);
