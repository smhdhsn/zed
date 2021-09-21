<?php

namespace Zed\Framework\Traits\Migration;

use Zed\Framework\Traits\Migration\Commands\{Migrate, Rollback, Fresh, Reset};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait MigrationCommands
{
    use Migrate, Rollback, Fresh, Reset;
}
