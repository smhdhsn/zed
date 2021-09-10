#!/usr/bin/env php
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
 * @package ZED
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
 * Mapping Predefined Commands.
 */
$command->modify('migrate', \App\Commands\MigrateCommand::class);
$command->modify('serve', \App\Commands\ServeCommand::class);
$command->modify('make', \App\Commands\MakeCommand::class);

/**
 * Executing Command.
 */
$app->execute();
