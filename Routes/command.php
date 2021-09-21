<?php

use Zed\Framework\CommandLineInterface as CLI;

/*
|--------------------------------------------------------------------------
| Command routes
|--------------------------------------------------------------------------
|
| Here is where you can register command routes for your application. 
|
*/

$command->modify('say', function (string $message = 'Hello') {
    return CLI::out($message);
});
