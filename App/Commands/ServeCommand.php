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

        echo CLI::out(
            CLI::GREEN 
            . "PHP-M development server started:" 
            . CLI::WHITE 
            . " <http://127.0.0.1:{$port}>"
        );

        exec("php -S localhost:{$port} -t Public");
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
  