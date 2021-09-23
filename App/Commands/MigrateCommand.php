<?php

namespace App\Commands;

use Zed\Framework\Migration\Strategy\{FreshMigration, ResetMigration, MigrateMigration, RollbackMigration};
use Zed\Framework\Migration\MigrationDatabaseManager as Manager;
use Zed\Framework\{CommandLineInterface as CLI, Migration};
use Zed\Framework\Migration\Contract\Migrateable;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class MigrateCommand
{
    /**
     * Extra arguments passed to script via command line.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public ?array $params;

    /**
     * Handle the command's action.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function handle(): string
    {
        $strategy = $this->getStrategy($this->params[0]);
        return $this->execute($strategy);
    }

    /**
     * Choose strategy based on sub-command passed via command line.
     * 
     * @since 1.0.1
     * 
     * @param null|string $type
     * 
     * @return Migrateable
     */
    private function getStrategy(?string $type): Migrateable
    {
        switch ($type) {
            case 'rollback':
                $strategy = new RollbackMigration;
                break;
            case null:
                $strategy = new MigrateMigration;
                break;
            case 'reset':
                $strategy = new ResetMigration;
                break;
            case 'fresh':
                $strategy = new FreshMigration;
                break;
            default:
                throw new Exception(
                    CLI::out('No such sub-command is defined!', CLI::RED . CLI::BLINK_FAST)
                );
        }

        return $strategy;
    }

    /**
     * Execute the command.
     * 
     * @since 1.0.1
     * 
     * @param Migrateable $strategy
     * 
     * @return string
     */
    private function execute(Migrateable $strategy): string
    {
        return (new Migration)
            ->setStrategy($strategy)
            ->setParam(new Manager)
            ->preExecution()
            ->execute()
            ->getMessage()
        ;
    }
}
