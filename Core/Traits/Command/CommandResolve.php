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
     * @param string $class
     * 
     * @return string|null
     */
    private function fromString(string $class): ?string
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
            return CLI::out($exception->getMessage(), CLI::RED);
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
        return CLI::out("Command Not Found !", CLI::RED);
    }
}
