<?php

namespace App\Commands;

use Core\Classes\BaseCommand;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class MigrationCommand extends BaseCommand
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
        return $this->success('Running Migrations...');
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
        return $this->error('Rolling Back Migrations...');
    }
}
