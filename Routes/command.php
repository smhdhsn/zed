<?php

use Core\Classes\CommandLineInterface as CLI;

/*
|--------------------------------------------------------------------------
| Command Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Command routes for your application. 
|
*/

$command->modify('migrate', \App\Commands\MigrateCommand::class);
$command->modify('make', \App\Commands\MakeCommand::class);

$command->modify('say', function (string $message = 'Hello') {
    return CLI::out($message);
});
