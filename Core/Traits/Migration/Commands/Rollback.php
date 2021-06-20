<?php

namespace Core\Traits\Migration\Commands;

use PDO;
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
        $batchNumber = $this->lastBatch();

        if ($batchNumber === 0)
            return CLI::out('Nothing To Rollback To !', CLI::BLINK_FAST);
        
        $migrations = $this->fetchLastBatch($batchNumber);

        foreach ($migrations as $migration) {
            require_once $this->getFile($migration['migration']);
            
            $className = $this->getClassName($migration['migration']);
            $class = "\\Database\\Migrations\\$className";

            $object = new $class();
            $object->backward(rtrim($migration['migration'], '.php'));
        }

        $this->destroy($batchNumber);

        return CLI::out('Rolled Back One Step !', CLI::BLINK_FAST);
    }

    /**
     * Running Down Method On One Step Of Migrations And Deleting Them From Database.
     * 
     * @since 1.0.0
     * 
     * @param string $migration
     * 
     * @return void
     */
    protected function backward(string $migration): void
    {
        echo CLI::out("Dismissing {$migration}", CLI::RED);
        $this->down();
        echo CLI::out("Dismissed  {$migration}", CLI::PURPLE);
    }
}
