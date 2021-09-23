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
class MigrateMigration implements Migrateable
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
     * @param Migration $manager
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
        $this->createTable();
        $this->setPendingMigration();

        if (empty($this->migrations))
            throw new Exception(CLI::out('Nothing to migrate!', CLI::RED . CLI::BLINK_FAST));

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
        $batch = $this->manager->lastBatch();

        foreach ($this->migrations as $migration) {
            require_once  Application::$path['migrations'] . "/{$migration}.php";

            $class = Str::extractClassname($migration);
            $object = new $class();

            echo CLI::out("Applying {$migration}", CLI::CYAN);
            array_map(fn($query) => $this->manager->exec($query), $object->up());
            $this->manager->store($migration, ++$batch);
            echo CLI::out("Applied  {$migration}", CLI::BLUE);
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
        return CLI::out('Migrate completed!', CLI::BLINK_FAST);
    }

    /**
     * Scan "Migrations" folder to get list of migrations, extract migrations that are 
     * not already applied from scanned files, then finally store pending migration(s)
     * in a property.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function setPendingMigration(): void
    {
        $files = scandir(Application::$path['migrations']);

        $this->migrations = array_filter(
            array_diff(
                array_map(fn($fil) => rtrim($fil, '.php'), $files), 
                $this->manager->getApplied()
            )
        );
    }

    /**
     * Create "migrations" table to keep track of implemented migration files.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function createTable(): void
    {
        $this->manager->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            batch INT
        ) ENGINE=INNODB;");
    }
}
