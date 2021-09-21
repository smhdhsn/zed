<?php

namespace App\Commands;

use Zed\Framework\Maker\Strategy\{CommandMaker, ControllerMaker, MigrationMaker, ModelMaker, RepositoryMaker, ServiceMaker};
use Zed\Framework\CommandLineInterface as CLI;
use Zed\Framework\Maker\Protocol\Makeable;
use Zed\Framework\Maker\Maker;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
final class MakeCommand
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
        $this->checkFilenameExistence();
        return $this->execute($strategy);
    }

    /**
     * Choose strategy based on sub-command passed via command line.
     * 
     * @since 1.0.1
     * 
     * @param string $type
     * 
     * @return Makeable
     */
    private function getStrategy(string $type): Makeable
    {
        switch ($type) {
            case 'repository':
                $strategy = new Maker(new RepositoryMaker);
                break;
            case 'controller':
                $strategy = new Maker(new ControllerMaker);
                break;
            case 'migration':
                $strategy = new Maker(new MigrationMaker);
                break;
            case 'service':
                $strategy = new Maker(new ServiceMaker);
                break;
            case 'command':
                $strategy = new Maker(new CommandMaker);
                break;
            case 'model':
                $strategy = new Maker(new ModelMaker);
                break;
            default:
                throw new Exception(
                    CLI::out('No such sub-command is defined!', CLI::RED)
                );
        }

        return $strategy;
    }

    /**
     * Check if filename is passed to the command via command line.
     * 
     * @since 1.0.1
     * 
     * @throws Exception if filename is not being passed by command line.
     * 
     * @return void
     */
    private function checkFilenameExistence(): void
    {
        if (! $this->params[1])
            throw new Exception(
                CLI::out("Please enter a name for your {$this->params[0]}!", CLI::BLINK_FAST . CLI::RED)
            );
    }

    /**
     * Execute the command.
     * 
     * @since 1.0.1
     * 
     * @param Makeable $strategy
     * 
     * @return string
     */
    private function execute(Makeable $strategy): string
    {
        return $strategy
            ->setFilename($this->params[1])
            ->getBlueprint()
            ->getDestination()
            ->fillPlaceholders()
            ->createFile()
            ->getMessage()
        ;
    }
}
