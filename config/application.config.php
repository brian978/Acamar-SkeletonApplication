<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

return [
    'independentModules' => false,
    'modulesPath' => 'module/',
    // Default configurations for the modules (can be overwritten by module specific setup)
    'modulesConfigs' => [
        'module.config.php',
        'routes.config.php',
    ],
    // Modules that the application has
    'modules' => [
        'Database' => [
            'configs' => [
                'database.config.php',
                'database.local.php'
            ],
            'runSetup' => true
        ],
        'Application' => [
            'configs' => null, // null: Use defaults; []: Don't load any configs, !empty([]): Load specified configs
            'runSetup' => false, // Run Setup class from module?
        ]
    ],
    'configCache' => [
        'enabled' => false,
        'lifetime' => 30, // in seconds
        'filePath' => 'data/cache/app.config.php'
    ]
];
