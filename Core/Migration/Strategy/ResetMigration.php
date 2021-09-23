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
class ResetMigration implements Migrateable
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
        if ($this->manager->lastBatch() === 0)
            throw new Exception(CLI::out('Nothing to reset!', CLI::RED . CLI::BLINK_FAST));

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
        foreach ($this->manager->getApplied() as $migration) {
            require_once Application::$path['migrations'] . "/{$migration}.php";

            $class = Str::extractClassname($migration);
            $object = new $class();

            echo CLI::out("Dismissing {$migration}", CLI::RED);
            array_map(fn($query) => $this->manager->exec($query), $object->down());
            $this->manager->destroyWhere('migration', $migration);
            echo CLI::out("Dismissed  {$migration}", CLI::PURPLE);
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
        return CLI::out('Migrations reseted!', CLI::BLINK_FAST);
    }
}
