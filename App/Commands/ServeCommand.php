<?php

namespace App\Commands;

use Zed\Framework\CommandLineInterface as CLI;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
final class ServeCommand
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
     * @return void
     */
    public function handle(): void
    {
        $port = $this->port();

        echo CLI::out(
            CLI::GREEN 
            . "ZED development server started:" 
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
  