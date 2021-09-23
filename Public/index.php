<?php

use Zed\Framework\Application;
use Dotenv\Dotenv;

/**
 * Autoloading installed applications and classes.
 */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Loading environment variables.
 * 
 * @package vlucas/phpdotenv
 */
(Dotenv::createImmutable(dirname(__DIR__)))->load();

/**
 * Creating an instance of the application.
 * 
 * @author @SMhdHsn
 * 
 * @package SMhdHsn/Zed
 * 
 * @version 1.0.1
 */
$app = new Application(dirname(__DIR__));

/**
 * Shorten the router instance's accessability.
 */
$router = $app->router;

/**
 * Get defined routes.
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'api.php';

/**
 * Resolve requested route.
 */
$app->resolve();
