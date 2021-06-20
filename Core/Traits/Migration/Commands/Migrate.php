<?php

namespace Core\Traits\Migration\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Migrate
{
    /**
     * Applying Migration Files.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function migrate(): string
    {
        $batch = $this->lastBatch();
        $migrations = $this->getToApply(
            $this->getApplied(), 
            $this->getFiles()
        );

        if (empty($migrations))
            return CLI::out('Nothing To Migrate !', CLI::BLINK_FAST);

        foreach ($migrations as $migration) {
            require_once $this->getFile($migration);
            
            $className = $this->getClassName($migration);
            $class = "\\Database\\Migrations\\$className";

            $object = new $class();
            $object->forward(rtrim($migration, '.php'), $batch);
        }

        return CLI::out('All Files Migrated !', CLI::BLINK_FAST);
    }
}
