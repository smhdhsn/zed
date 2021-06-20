<?php

namespace App\Commands;

use Core\Interfaces\Console;
use Core\Classes\{CommandLineInterface as CLI, Migration};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class MigrateCommand extends Migration implements Console
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
                return CLI::out('Command Not Found !', CLI::RED);
        }
    }

    /**
     * Running Down Method On 1 Batch.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function rollback(): string
    {
        return CLI::out('Rolled Back One Batch !', CLI::BLINK_FAST);
    }

    /**
     * Running Down Then Up Methods On Every Migration.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function fresh(): string
    {
        return CLI::out('All Migrations Reruned !', CLI::BLINK_FAST);
    }

    /**
     * Running Down Method On Every Migration.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function reset(): string
    {
        return CLI::out('All Migrations Reseted !', CLI::BLINK_FAST);
    }
}
