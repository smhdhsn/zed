<?php

namespace Zed\Framework\Migration\Strategy;

use Zed\Framework\Migration\MigrationDatabaseManager as Manager;
use Zed\Framework\{CommandLineInterface as CLI, Application};
use Zed\Framework\Migration\Contract\Migrateable;
use Zed\Framework\Migration;
use FilesystemIterator;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class FreshMigration implements Migrateable
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
        $directoryEmpty = !(new FilesystemIterator(Application::$path['migrations']))->valid();
        if ($directoryEmpty)
            throw new Exception(CLI::out('Nothing to refresh!', CLI::RED . CLI::BLINK_FAST));

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
        $context = new Migration;

        try {
            $context
                ->setStrategy(new ResetMigration)
                ->setParam($this->manager)
                ->preExecution()
                ->execute()
            ;
        } catch (Exception $exception) {}

        $context
            ->setStrategy(new MigrateMigration)
            ->setParam($this->manager)
            ->preExecution()
            ->execute()
        ;

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
        return CLI::out('Migrations refreshed!', CLI::BLINK_FAST);
    }
}
