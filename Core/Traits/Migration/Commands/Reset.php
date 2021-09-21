<?php

namespace Zed\Framework\Traits\Migration\Commands;

use Zed\Framework\CommandLineInterface as CLI;

/**
 * @author @SMhdHsn
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
        $migrations = $this->getApplied();

        foreach ($migrations as $migration) {
            require_once $this->getFile($migration);
            
            $className = $this->getClassName($migration);
            $class = "\\Database\\Migrations\\$className";

            $object = new $class();
            $object->backward(rtrim($migration, '.php'));

            $this->destroyWhere('migration', $migration);
        }

        return CLI::out('Migrations Reseted !', CLI::BLINK_FAST);
    }
}
