#!/usr/bin/env php
<?php

use Core\Classes\Application;
use Dotenv\Dotenv;

/**
 * Autoloading installed applications and classes.
 */
require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Loading environment variables.
 * 
 * @package vlucas/phpdotenv
 */
(Dotenv::createImmutable(__DIR__))->load();

/**
 * Creating an instance of the application.
 * 
 * @author @SMhdHsn
 * 
 * @package SMhdHsn/Zed
 * 
 * @version 1.0.1
 */
$app = new Application(__DIR__);

/**
 * Shorten the command instance's accessability.
 */
$command = $app->command;

/**
 * Get defined commands.
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR . 'command.php';

/**
 * Map predefined commands.
 */
$command->modify('migrate', \App\Commands\MigrateCommand::class);
$command->modify('serve', \App\Commands\ServeCommand::class);
$command->modify('make', \App\Commands\MakeCommand::class);

/**
 * Executing command.
 */
$app->execute();
