<?php

namespace App\Commands;

use Zed\Framework\{CommandLineInterface as CLI, Migration};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class MigrateCommand extends Migration
{
    /**
     * Extra arguments passed to script via command line.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public ?array $params;

    /**
     * Handle the command's action.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function handle(): string
    {
        switch ($this->params[0]) {
            case null:
                return $this->migrate();
            case 'rollback':
                return $this->rollback();
            case 'fresh':
                return $this->fresh();
            case 'reset':
                return $this->reset();
            default:
                return CLI::out('No such sub-command is defined!', CLI::RED);
        }
    }
}
