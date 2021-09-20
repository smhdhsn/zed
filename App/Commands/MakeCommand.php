<?php

namespace App\Commands;

use Core\Classes\{CommandLineInterface as CLI, Making};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class MakeCommand extends Making
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
        switch ($this->params[0]) {
            case 'repository':
                return $this->repository($this->params);
            case 'controller':
                return $this->controller($this->params);
            case 'migration':
                return $this->migration($this->params);
            case 'service':
                return $this->service($this->params);
            case 'command':
                return $this->command($this->params);
            case 'model':
                return $this->model($this->params);
            default:
                return CLI::out('No such sub-command is defined!', CLI::RED);
        }
    }
}
