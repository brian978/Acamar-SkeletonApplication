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

/**
 * ----------------------------------------
 * Loading our initial files
 * ----------------------------------------
 */
$acamarPath  = realpath(getenv('ACAMAR_PATH'));

require_once $acamarPath . '/Acamar/Loader/PSR0Autoloader.php';

/**
 * ----------------------------------------
 * Configuring the autoloader
 * ----------------------------------------
 */
// We need the autoloader as soon as possible
$autoloader = new PSR0Autoloader();
$autoloader->registerNamespaces([
    'Acamar' => $acamarPath
]);

$autoloader->register();

/**
 * ----------------------------------------
 * Loading the application
 * ----------------------------------------
 */
$app = new Application(getenv("APPLICATION_ENV") || Application::ENV_PRODUCTION);
$app->setAutoloader($autoloader);

/**
 * ----------------------------------------
 * Configuring the application & run
 * (must be done after autoloading config)
 * ----------------------------------------
 */
$app->loadConfig()
    ->run();

// Just some benchmarks to keep an eye on
echo "<br /><br />";
echo "<h3>Benchmark</h3><hr>";
echo "<br />";
echo "<b>Memory peak usage:</b> " . (memory_get_peak_usage() / 1024 / 1024) . " MB <br /><br />";
echo "<b>Memory usage:</b> " . (memory_get_usage() / 1024 / 1024) . " MB<br /><br />";
echo "<b>Loaded files:</b> " . count(get_included_files()) . "<br /><br />";
echo "<b>List of files:</b> <pre>" . var_export(get_included_files(), 1) . "</pre>";
