<?php

namespace App\Commands;

use Core\Interfaces\Console;
use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class MigrateCommand implements Console
{
    /**
     * Extra Arguments Passed To Script Via Command Line.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public ?array $params;

    /**
     * This Method Handles The Command's Action.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function handle(): string
    {
        return CLI::BLINK_FAST . CLI::success('Migration Command');
    }
}
