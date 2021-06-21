<?php

namespace App\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class ServeCommand
{
    /**
     * This Method Handles The Command's Action.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function handle()
    {
        $port = $this->port();

        exec("cd Public && php -S localhost:{$port}");
    }

    /**
     * Getting Port Number.
     * (Default Port Is 8000)
     * 
     * @since 1.0.0
     * 
     * @return int
     */
    private function port(): int
    {
        return explode('=', $_SERVER['argv'][2])[1] ?? 8000;
    }
}
  