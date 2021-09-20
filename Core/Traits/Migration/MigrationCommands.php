<?php

namespace Core\Traits\Migration;

use Core\Traits\Migration\Commands\{Migrate, Rollback, Fresh, Reset};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait MigrationCommands
{
    use Migrate, Rollback, Fresh, Reset;
}
