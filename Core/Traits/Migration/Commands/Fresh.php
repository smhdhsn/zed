<?php

namespace Core\Traits\Migration\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Fresh
{
    /**
     * Running Down Then Up Methods On Every Migration.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function fresh(): string
    {
        $this->reset();

        $this->createTable();

        $this->migrate();

        return CLI::out('All Migrations Reruned !', CLI::BLINK_FAST);
    }
}
