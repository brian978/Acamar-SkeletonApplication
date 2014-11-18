<?php
/**
 * SlimMVC-SkeletonApplication
 *
 * @link https://github.com/brian978/SlimMVC-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license Creative Commons Attribution-ShareAlike 3.0
 */

return array(
    'routes' => array(
        'home' => array(
            'pattern' => '/',
            'defaults' => array(
                'module' => 'Application',
                'controller' => 'index',
                'action' => 'index'
            )
        ),
        'error' => array(
            'pattern' => '/error',
            'defaults' => array(
                'module' => 'Application',
                'controller' => 'error',
                'action' => 'index'
            )
        ),
        'mvc' => array(
            'pattern' => '/:controller(/:action)',
            'defaults' => array(
                'module' => 'Application'
            )
        )
    )
);
