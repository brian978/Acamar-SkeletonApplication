<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license Creative Commons Attribution-ShareAlike 3.0
 */

return array(
    'baseUri' => '/',
    'independentModules' => false,
    'modulesPath' => 'module/',
    'modulesConfigs' => [
        'module.config.php',
        'routes.config.php',
    ],
    'modules' => [
        'Application' => [
            'configs' => null,
            'runSetup' => false,
        ]
    ],
    'configCache' => [
        'enabled' => false,
        'filePath' => 'cache/app.config.php'
    ]
);
