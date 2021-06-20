<?php

namespace Core\Traits\Migration\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Rollback
{
    /**
     * Running Down Method On 1 Batch.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function rollback(): string
    {
        return CLI::out('Rolled Back One Batch !', CLI::BLINK_FAST);
    }
}
