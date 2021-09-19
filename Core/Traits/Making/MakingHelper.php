<?php

namespace Core\Traits\Making;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingHelper
{
    /**
     * Getting Template File's Content.
     * 
     * @since 1.0.0
     * 
     * @param string $path
     * 
     * @return string
     */
    private function getContent(string $path): string
    {
        $myfile = fopen($path, "r");
        $content = fread($myfile, filesize($path));
        fclose($myfile);

        return $content;
    }

    /**
     * Getting Full Path To Requested Template's File.
     * 
     * @since 1.0.0
     * 
     * @param string $file
     * 
     * @return string
     */
    private function templatePath(string $file): string
    {
        return dirname(__DIR__, 2)
        . DIRECTORY_SEPARATOR
        . 'BluePrints'
        . DIRECTORY_SEPARATOR
        . "{$file}Template.txt";
    }

    /**
     * Getting Full Path To Requested Template's File.
     * 
     * @since 1.0.0
     * 
     * @param string $mainFolder
     * @param string $fileName
     * @param string $folder
     * 
     * @return string
     */
    private function originPath(string $mainFolder, string $folder, string $fileName): string
    {
        return dirname(__DIR__, 3)
        . DIRECTORY_SEPARATOR
        . $mainFolder
        . DIRECTORY_SEPARATOR
        . $folder
        . DIRECTORY_SEPARATOR
        . $fileName
        . '.php';
    }

    /**
     * Creating File In Given Path With Given Name.
     * 
     * @since 1.0.0
     * 
     * @param string $content
     * @param string $path
     * 
     * @return void
     */
    private function createFile(string $path, string $content): void
    {
        $myfile = fopen($path, "w");
        fwrite($myfile, $content);
        fclose($myfile);
    }
}
