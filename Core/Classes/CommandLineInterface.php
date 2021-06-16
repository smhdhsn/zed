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
     * Command Line Colors.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST RESET = "\033[0m";
    CONST RED = "\033[31m";
    CONST BLACK = "\033[30m";
    CONST GREEN = "\033[32m";
    CONST YELLOW = "\033[33m";
    CONST BLUE = "\033[34m";
    CONST PURPLE = "\033[35m";
    CONST CYAN = "\033[36m";
    CONST WHITE = "\033[37m";

    /**
     * Command Line Options.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST EOL = "\n";
    CONST TAB = "\t";
}