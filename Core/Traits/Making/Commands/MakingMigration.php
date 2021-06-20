<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingMigration
{
    /**
     * Making a Migration With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function migration(array $params): string
    {
        return CLI::out('This Section Is Under Construction !', CLI::BLINK_FAST);
    }
}
