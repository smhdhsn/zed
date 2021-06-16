<?php

use Dotenv\Dotenv;
use Core\Classes\Application;

/**
 * Autoloading Installed Applications And Classes.
 */
require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Loading Environment Variables.
 * 
 * @since 1.0.0
 * 
 * @package vlucas/phpdotenv
 */
(Dotenv::createImmutable(__DIR__))->load();

/**
 * Creating an Instance Of The Application.
 * 
 * @author @smhdhsn
 * 
 * @package php-m
 * 
 * @version 1.0.0
 */
$app = new Application;

/**
 * Shorten The Command Instance's Accessability.
 */
$command = $app->command;

/**
 * Getting Command Routing From Routes Folder.
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'command.php';

/**
 * Executing Command.
 */
$app->execute();
