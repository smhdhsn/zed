<?php

use Dotenv\Dotenv;
use Core\Classes\Application;

/**
 * Autoloading Installed Applications And Classes.
 */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Loading Environment Variables.
 * 
 * @since 1.0.0
 * 
 * @package vlucas/phpdotenv
 */
(Dotenv::createImmutable(dirname(__DIR__)))->load();

/**
 * Creating an Instance Of The Application.
 * 
 * @author @smhdhsn
 * 
 * @package ZED
 * 
 * @version 1.0.0
 */
$app = new Application;

/**
 * Shorten The Router Instance's Accessability.
 */
$router = $app->router;

/**
 * Getting Routings From Routes Folder.
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'api.php';

/**
 * Resolve Requested Route.
 */
$app->resolve();
