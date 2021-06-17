<?php

namespace Core\Traits\Command;

use Exception;
use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait CommandResolve
{
    /**
     * Executing The Command.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function execute(): ?string
    {
        $callback = $this->getCallback();

        if (! is_null($callback))
            $this->saveParams();

        switch (gettype($callback)) {
            case 'NULL':
                return $this->commandNotFound();
            break;
            case 'array':
                return $this->fromArray($callback);
            break;
            case 'string':
                return $this->fromString($callback);
            break;
            case 'object':
                return $this->fromClosure($callback);
            break;
        }
    }

    /**
     * In Case Command Is Mapped Using "Command@Action" Syntax.
     * 
     * @since 1.0.0
     * 
     * @param string $map
     * 
     * @return string|null
     */
    private function fromString(string $map): ?string
    {
        try {
            $parts = explode('@', $map);

            $class = "\\App\\Commands\\$parts[0]";

            $callback = [
                new $class(),
                $parts[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return CLI::error($exception->getMessage());
        }
    }

    /**
     * In Case Command Is Mapped Using [Command::class, 'action'] Syntax.
     * 
     * @since 1.0.0
     * 
     * @param array $map
     * 
     * @return string|null
     */
    private function fromArray(array $map): ?string
    {
        try {
            $callback = [
                new $map[0],
                $map[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return CLI::error($exception->getMessage());
        }
    }

    /**
     * In Case Command's Callback Is a Closure.
     * 
     * @since 1.0.0
     * 
     * @param object $callback
     * 
     * @return string|null
     */
    private function fromClosure(object $callback): ?string
    {
        try {
            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return CLI::error($exception->getMessage());
        }
    }

    /**
     * In Case Executed Command Doesn't Exist.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function commandNotFound(): string
    {
        return CLI::error("Command Not Found !");
    }
}
