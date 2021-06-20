<?php

namespace Core\Traits\Migration\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Reset
{
    /**
     * Running Down Method On Every Migration.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function reset(): string
    {
        echo CLI::out('Migrations Table Is Being Dropped !', CLI::RED);
        $this->connection->exec("DROP TABLE IF EXISTS migrations;");
        echo CLI::out('Migrations Table Has Been Dropped !', CLI::PURPLE);

        return CLI::out('All Migrations Reseted !', CLI::BLINK_FAST);
    }
}
