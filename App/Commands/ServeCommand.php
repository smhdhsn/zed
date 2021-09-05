<?php

namespace App\Commands;

use Core\Classes\CommandLineInterface as CLI;
use Core\Interfaces\OpenEndedCommand as OEC;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class ServeCommand implements OEC
{
    /**
     * Extra Arguments Passed To Script Via Command Line.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public ?array $params;

    /**
     * This Method Handles The Command's Action.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function handle(): void
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
        return explode('=', $this->params[0])[1] ?? 8000;
    }
}
  