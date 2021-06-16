<?php

namespace Core\Classes;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class BaseCommand extends CommandLineInterface
{
    /**
     * Styling Output For Successful Messages.
     *
     * @since 1.0.0
     *
     * @param string $message
     *
     * @return string
     */
    public function success(string $message): string
    {
        return CLI::GREEN . $message . CLI::EOL;
    }

    /**
     * Styling Output For Unsuccessful Messages.
     *
     * @since 1.0.0
     *
     * @param string $message
     *
     * @return string
     */
    public function error(string $message): string
    {
        return CLI::RED . $message . CLI::EOL;
    }
}
