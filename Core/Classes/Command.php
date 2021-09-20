<?php

namespace Core\Classes;

use Core\Traits\Command\{CommandHelper as Helper, CommandResolve as Resolve};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Command extends Database
{
    use Resolve, Helper;

    /**
     * Command list.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $commands;

    /**
     * The command passed to script via command line.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?string $argument;

    /**
     * Extra arguments passed to script via command line.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Save command.
     * 
     * @since 1.0.0
     * 
     * @param string $commandName
     * @param mixed $callback
     * 
     * @return void
     */
    public function modify(string $commandName, $callback): void
    {
        $this->saveCommand($commandName, $callback);
    }
}
