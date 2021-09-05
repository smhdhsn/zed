<?php

namespace App\Commands;

use Core\Classes\{CommandLineInterface as CLI, Migration};
use Core\Interfaces\CloseEndedCommand as CEC;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class MigrateCommand extends Migration implements CEC
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
                return CLI::out('Sub-Command Not Found !', CLI::RED);
        }
    }
}
