<?php

namespace Zed\Framework\Migration\Contract;

use Zed\Framework\Migration\MigrationDatabaseManager as Manager;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface Migrateable
{
    /**
     * Prepare execution's parameters.
     * 
     * @since 1.0.1
     * 
     * @param Manager $manager
     * 
     * @return Migrateable
     */
    public function setParam(Manager $manager): Migrateable;

    /**
     * Check if execution of the command is needed.
     * 
     * @since 1.0.1
     * 
     * @throws Exception if the execution is not needed.
     * 
     * @return Migrateable
     */
    public function preExecution(): Migrateable;

    /**
     * Execute actual command.
     * 
     * @since 1.0.1
     * 
     * @return Migrateable
     */
    public function execute(): Migrateable;

    /**
     * Get proper message for showing in terminal.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function getMessage(): string;
}
