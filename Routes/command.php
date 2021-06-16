<?php

use Core\Classes\BaseCommand;

/*
|--------------------------------------------------------------------------
| Command Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Command routes for your application. 
|
*/

$command->modify('migrate', 'MigrationCommand@migrate');
$command->modify('migrate:rollback', 'MigrationCommand@rollback');

$command->modify('say', function ($message = 'Hello') {
    return (new BaseCommand)->success($message);
});
