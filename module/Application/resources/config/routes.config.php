<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

return [
    'routes' => [
        'home' => [
            'pattern' => '/',
            'defaults' => [
                'module' => 'Application',
                'controller' => 'index',
                'action' => 'index'
            ],
            'options' => [
                'acceptedHttpMethods' => [
                    'GET'
                ]
            ],
        ],
        'error' => [
            'pattern' => '/error',
            'defaults' => [
                'module' => 'Application',
                'controller' => 'error',
                'action' => 'index'
            ]
        ],
        'mvc' => [
            'pattern' => '/:controller(/:action(/:id))',
            'defaults' => [
                'module' => 'Application'
            ]
        ]
    ]
];
