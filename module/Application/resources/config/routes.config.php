<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

return array(
    'routes' => array(
        'home' => array(
            'pattern' => '/',
            'defaults' => array(
                'module' => 'Application',
                'controller' => 'index',
                'action' => 'index'
            ),
            'options' => array(
                'acceptedHttpMethods' => array(
                    'GET'
                )
            ),
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
