<?php

namespace Zed\Framework\Migration\Strategy;

use Zed\Framework\{CommandLineInterface as CLI, Application, Str};
use Zed\Framework\Migration\MigrationDatabaseManager as Manager;
use Zed\Framework\Migration\Contract\Migrateable;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class RollbackMigration implements Migrateable
{
    /**
     * Database manager's instance.
     * 
     * @since 1.0.1
     * 
     * @var Manager
     */
    private Manager $manager;

    /**
     * Prepare execution's parameters.
     * 
     * @since 1.0.1
     * 
     * @param Manager $manager
     * 
     * @return Migrateable
     */
    public function setParam(Manager $manager): Migrateable
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Check if execution of the command is needed.
     * 
     * @since 1.0.1
     * 
     * @throws Exception if the execution is not needed.
     * 
     * @return Migrateable
     */
    public function preExecution(): Migrateable
    {
        $this->batchNumber = $this->manager->lastBatch();
        if ($this->batchNumber === 0)
            throw new Exception(CLI::out('Nothing to rollback!', CLI::RED . CLI::BLINK_FAST));

        return $this;
    }

    /**
     * Execute actual command.
     * 
     * @since 1.0.1
     * 
     * @return Migrateable
     */
    public function execute(): Migrateable
    {
        $migrations = $this->manager->fetchLastStep($this->batchNumber);

        foreach ($migrations as $migration) {
            require_once  Application::$path['migrations'] . "/{$migration['migration']}.php";

            $class = Str::extractClassname($migration['migration']);
            $object = new $class();

            echo CLI::out("Dismissing {$migration['migration']}", CLI::RED);
            array_map(fn($query) => $this->manager->exec($query), $object->down());
            $this->manager->destroyWhere('batch', $this->batchNumber);
            echo CLI::out("Dismissed  {$migration['migration']}", CLI::PURPLE);
        }

        return $this;
    }

    /**
     * Get proper message for showing in terminal.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return CLI::out('Rolled back one step!', CLI::BLINK_FAST);
    }
}
