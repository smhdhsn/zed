<?php

namespace Core\Classes;

use Core\Traits\Command\{CommandHelper as Helper, CommandResolve as Resolve};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Command extends Database
{
    use Resolve, Helper;

    /**
     * Application's Commands.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $commands;

    /**
     * The Command Passed To Script Via Command Line.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?string $argument;

    /**
     * Extra Arguments Passed To Script Via Command Line.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Saving Commands.
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
