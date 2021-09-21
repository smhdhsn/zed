<?php

namespace Zed\Framework;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class File
{
    /**
     * Get content of a file.
     * 
     * @since 1.0.1
     * 
     * @param string $path
     * 
     * @return string
     */
    public static function getFileContent(string $path): string
    {
        $myfile = fopen($path, "r");
        $content = fread($myfile, filesize($path));
        fclose($myfile);

        return $content;
    }

    /**
     * Create a file in a given path.
     * 
     * @since 1.0.1
     * 
     * @param string $content
     * @param string $path
     * 
     * @return void
     */
    public static function createFile(string $content, string $path): void
    {
        $myfile = fopen($path, "w");
        fwrite($myfile, $content);
        fclose($myfile);
    }

    /**
     * Place value(s) in related placeholder(s).
     * 
     * @since 1.0.1
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