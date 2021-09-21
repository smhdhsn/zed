<?php

namespace Zed\Framework\Traits\Migration\Commands;

use Zed\Framework\CommandLineInterface as CLI;
use PDO;

/**
 * @author @SMhdHsn
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
        $batchNumber = $this->lastBatch();

        if ($batchNumber === 0)
            return CLI::out('Nothing To Rollback To !', CLI::BLINK_FAST);
        
        $migrations = $this->fetchLastStep($batchNumber);

        foreach ($migrations as $migration) {
            require_once $this->getFile($migration['migration']);
            
            $className = $this->getClassName($migration['migration']);
            $class = "\\Database\\Migrations\\$className";

            $object = new $class();
            $object->backward(rtrim($migration['migration'], '.php'));
        }

        $this->destroyWhere('batch', $batchNumber);

        return CLI::out('Rolled Back One Step !', CLI::BLINK_FAST);
    }
}
