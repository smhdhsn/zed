<?php

namespace Zed\Framework;

use Zed\Framework\CommandLineInterface as CLI;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Command
{
    /**
     * Command list.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $commands;

    /**
     * The command passed to script via command line.
     * 
     * @since 1.0.1
     * 
     * @var array|null
     */
    private ?string $argument;

    /**
     * Extra arguments passed to script via command line.
     * 
     * @since 1.0.1
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct()
    {
        $this->setArgument();
    }

    /**
     * Save command.
     * 
     * @since 1.0.1
     * 
     * @param string $commandName
     * @param mixed $callback
     * 
     * @return void
     */
    public function modify(string $commandName, $callback): void
    {
        $this->commands[$commandName] = $callback;
    }

    /**
     * Execute the command.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function execute(): ?string
    {
        $callback = $this->commands[$this->argument];

        if (! is_null($callback))
            $this->saveParams();

        switch (gettype($callback)) {
            case 'NULL':
                return CLI::out("Command not found!", CLI::RED);

            case 'string':
                return $this->mapClass($callback);

            case 'object':
                return $this->invokeClosure($callback);
        }
    }

    /**
     * In case command is mapped using "Command@Action" syntax.
     * 
     * @since 1.0.1
     * 
     * @param string $class
     * 
     * @return string|null
     */
    private function mapClass(string $class): ?string
    {
        try {
            $object = new $class();
            $object->params = $this->params;

            $callback = [
                $object,
                'handle'
            ];

            return call_user_func($callback);
        } catch (Exception $exception) {
            return CLI::out($exception->getMessage(), CLI::RED);
        }
    }

    /**
     * In case command's callback is a closure.
     * 
     * @since 1.0.1
     * 
     * @param object $callback
     * 
     * @return string|null
     */
    private function invokeClosure(object $callback): ?string
    {
        try {
            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return CLI::out($exception->getMessage(), CLI::RED);
        }
    }

    /**
     * Store sub-command inside "argument" variable and any arguments after that in "params" variable.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function setArgument(): void
    {
        $exploded = explode(':', $_SERVER['argv'][1]);

        $this->argument = $exploded[0] ?? null;

        if ($exploded[1])
            $this->params[] = $exploded[1];
    }

    /**
     * Save command line's passed parameter(s) inside "params" variable.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function saveParams(): void
    {
        for ($i = 2; $i < count($_SERVER['argv']); $i++) {
            $this->params[] = $_SERVER['argv'][$i];
        }
    }
}
