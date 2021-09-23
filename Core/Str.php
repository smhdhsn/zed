<?php

namespace Zed\Framework;

class Str
{
    /**
     * Convert strings of type PascalCase to snake_case.
     * 
     * @since 1.0.1
     * 
     * @param string $input
     * 
     * @return string
     */
    public static function pascalToSnake(string $input): string
    {
        return strtolower(
            preg_replace('/(?<!^)[A-Z]/', '_$0', $input)
        );
    }

    /**
     * Convert strings of type snake_case to PascalCase.
     * 
     * @since 1.0.1
     * 
     * @param string $input
     * 
     * @return string
     */
    public static function snakeToPascal(string $input): string
    {
        return str_replace('_', '', ucwords(strtolower($input), '_'));
    }

    /**
     * Extract migration's classname from filename, then add namespace to it.
     * 
     * @since 1.0.1
     * 
     * @param string $input
     * 
     * @return string
     */
    public static function extractClassname(string $input)
    {
        return "\\Database\\Migrations\\" . self::snakeToPascal(
            preg_replace('/[0-9]+/', '', rtrim($input, '.php'))
        );
    }
}
