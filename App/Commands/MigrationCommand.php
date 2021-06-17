<?php

namespace App\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class MigrationCommand
{
    /**
     * Running Migrations.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function migrate(): string
    {
        return CLI::success('Running Migrations...');
    }

    /**
     * Rolling Back Migrations.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function rollback(): string
    {
        return CLI::error('Rolling Back Migrations...');
    }
}
