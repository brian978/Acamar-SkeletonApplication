<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license Creative Commons Attribution-ShareAlike 3.0
 */

use Acamar\Loader\PSR0Autoloader;
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
    $acamarPath = realpath('vendor/Acamar');
}

/**
 * ----------------------------------------
 * Configuring the autoloader
 * ----------------------------------------
 */
require_once $acamarPath . '/Acamar/Loader/PSR0Autoloader.php';

// We need this autoloader because the application depends on it
$autoloader = new PSR0Autoloader();
$autoloader->registerNamespaces([
    'Acamar' => $acamarPath
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
$app = new Application(APPLICATION_ENV);
$app->setAutoloader($autoloader);

/**
 * ----------------------------------------
 * Configuring the application & run
 * (must be done after autoloading config)
 * ----------------------------------------
 */
$app->run();

// Just some benchmarks to keep an eye on
echo "<br /><br />";
echo "<h3>Benchmark</h3><hr>";
echo "<br />";
echo "<b>Memory peak usage:</b> " . (memory_get_peak_usage() / 1024 / 1024) . " MB <br /><br />";
echo "<b>Memory usage:</b> " . (memory_get_usage() / 1024 / 1024) . " MB<br /><br />";
echo "<b>Execution time:</b> " . (microtime(true) - $startTime) . " ms<br /><br />";
echo "<b>Loaded files:</b> " . count(get_included_files()) . "<br /><br />";
echo "<b>List of files:</b> <pre>" . var_export(get_included_files(), 1) . "</pre>";
