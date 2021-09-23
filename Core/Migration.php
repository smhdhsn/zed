<?php

namespace Zed\Framework;

use Zed\Framework\Migration\MigrationDatabaseManager as Manager;
use Zed\Framework\Migration\Contract\Migrateable;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Migration implements Migrateable
{
    /**
     * Migration strategy's instance.
     * 
     * @since 1.0.1
     * 
     * @var Migrateable
     */
    private Migrateable $strategy;

    /**
     * Set strategy's instance.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function setStrategy(Migrateable $strategy): Migrateable
    {
        $this->strategy = $strategy;

        return $this;
    }

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
        $this->strategy->setParam($manager);

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
        $this->strategy->preExecution();

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
        $this->strategy->execute();

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
        return $this->strategy->getMessage();
    }
}
