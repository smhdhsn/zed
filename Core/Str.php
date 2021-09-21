<?php

namespace Zed\Framework;

class Str
{
    /**
     * Convert strings of type PascalCase to snake_case.
     * 
     * @since 1.0.0
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
     * @since 1.0.0
     * 
     * @param string $input
     * 
     * @return string
     */
    public static function snakeToPascal(string $input): string
    {
        return str_replace('_', '', ucwords(strtolower($input), '_'));
    }
}
