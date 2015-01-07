<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

use Acamar\Loader\PSR4Autoloader;
use Acamar\Mvc\Application;

chdir(dirname(__DIR__));

ini_set('display_errors', 1);
error_reporting(E_ALL);

$startTime = microtime(true);

// There might be an autoloader from Composer
$loaderPath = realpath('vendor/autoload.php');
if (file_exists($loaderPath)) {
    $loader = include $loaderPath;
}

// Getting the framework path
$acamarPath = getenv('ACAMAR_PATH');
if (!$acamarPath) {
    $acamarPath = realpath('vendor/brian978/acamar');
}

/**
 * ----------------------------------------
 * Configuring the autoloader
 * ----------------------------------------
 */
require_once $acamarPath . '/Acamar/Loader/PSR4Autoloader.php';

// We need this autoloader because the application depends on it
$autoloader = new PSR4Autoloader();
$autoloader->registerNamespaces([
    'Acamar' => $acamarPath . '/Acamar',
    'Aura' => 'vendor/Aura'
]);

$autoloader->register();

/**
 * ----------------------------------------
 * Application environment
 * ----------------------------------------
 */
$env = getenv("APPLICATION_ENV");
define('APPLICATION_ENV', $env === false ? Application::ENV_PRODUCTION : $env);

/**
 * ----------------------------------------
 * Loading the application
 * ----------------------------------------
 */
$app = new Application(APPLICATION_ENV, $autoloader);

/**
 * ----------------------------------------
 * Configuring the application & run
 * (must be done after autoloading config)
 * ----------------------------------------
 */
$app->run();
