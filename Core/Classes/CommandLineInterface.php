<?php

namespace Core\Classes;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class CommandLineInterface
{
    /**
     * Command Line Foreground Colors.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST RED = "\033[31m";
    CONST BLACK = "\033[30m";
    CONST GREEN = "\033[32m";
    CONST YELLOW = "\033[33m";
    CONST BLUE = "\033[34m";
    CONST PURPLE = "\033[35m";
    CONST CYAN = "\033[36m";
    CONST WHITE = "\033[37m";

    /**
     * Command Line Background Colors.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST BG_BLACK = "\033[40m";
    CONST BG_RED = "\033[41m";
    CONST BG_GREEN = "\033[42m";
    CONST BG_YELLOW = "\033[43m";
    CONST BG_BLUE = "\033[44m";
    CONST BG_PURPLE = "\033[45m";
    CONST BG_CYAN = "\033[46m";
    CONST BG_WHITE = "\033[47m";

    /**
     * Command Line Options.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST EOL = "\n";
    CONST TAB = "\t";
    CONST RESET = "\033[0m";
    CONST ITALIC = "\033[3m";
    CONST UNDERLINE = "\033[4m";
    CONST BLINK_SLOW = "\033[5m";
    CONST BLINK_FAST = "\033[6m";
    CONST REVERSE = "\033[7m";
    CONST HIDE = "\033[8m";
    CONST CROSS = "\033[9m";

    /**
     * Styling Output For Normal Messages.
     *
     * @since 1.0.0
     *
     * @param string $message
     *
     * @return string
     */
    public static function out(string $message): string
    {
        return self::EOL . self::RESET . $message . self::EOL . self::RESET;
    }

    /**
     * Styling Output For Successful Messages.
     *
     * @since 1.0.0
     *
     * @param string $message
     *
     * @return string
     */
    public static function success(string $message): string
    {
        return self::EOL . self::GREEN . $message . self::EOL . self::RESET;
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
    public static function error(string $message): string
    {
        return self::EOL . self::RED . $message . self::EOL . self::RESET;
    }
}
