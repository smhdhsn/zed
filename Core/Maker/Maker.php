<?php

namespace Zed\Framework\Maker;

use Zed\Framework\Maker\Making\MakingCommands as Actions;
use Zed\Framework\Application;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Maker
{
    use Actions;

    /**
     * Get blueprint.
     * 
     * @since 1.0.0
     * 
     * @param string $classType
     * 
     * @return string
     */
    private function getBlueprint(string $classType): string
    {
        $path = Application::$frameworkRoot
        . DIRECTORY_SEPARATOR
        . 'Core'
        . DIRECTORY_SEPARATOR
        . 'Maker'
        . DIRECTORY_SEPARATOR
        . 'BluePrints'
        . DIRECTORY_SEPARATOR
        . "{$classType}.txt";

        $myfile = fopen($path, "r");
        $content = fread($myfile, filesize($path));
        fclose($myfile);

        return $content;
    }

    /**
     * Path to a certain section of application.
     * 
     * @since 1.0.0
     * 
     * @param string $mainFolder
     * @param string $folder
     * @param string $file
     * 
     * @return string
     */
    private function originPath(string $mainFolder, string $folder, string $file): string
    {
        return Application::$appRoot
        . DIRECTORY_SEPARATOR
        . $mainFolder
        . DIRECTORY_SEPARATOR
        . $folder
        . DIRECTORY_SEPARATOR
        . "{$file}.php";
    }

    /**
     * Create given class in a given path.
     * 
     * @since 1.0.0
     * 
     * @param string $content
     * @param string $path
     * 
     * @return void
     */
    private function createFile(string $content, string $path): void
    {
        $myfile = fopen($path, "w");
        fwrite($myfile, $content);
        fclose($myfile);
    }
}
