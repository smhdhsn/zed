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

    /**
     * Place value(s) in related placeholder(s).
     * #TODO: WRONG PLACED
     * 
     * @since 1.0.0
     * 
     * @param array $information
     * @param string $content
     * 
     * @return string
     */
    public static function placeValue(array $information, string $content): string
    {
        foreach ($information as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        return $content;
    }
}
