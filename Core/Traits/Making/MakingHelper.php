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
        return dirname(dirname(__DIR__))
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
        return dirname(dirname(dirname(__DIR__)))
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
    private function createFile(string $path, string $content)
    {
        $myfile = fopen($path, "w");
        fwrite($myfile, $content);
        fclose($myfile);
    }

    /**
     * Replacing Placeholders On Template Files With Proper Value.
     * 
     * @since 1.0.0
     * 
     * @param string $content
     * @param string $param
     * 
     * @return string
     */
    private function replacePlaceholders(string $content, string $param): string
    {
        $content = str_replace("Xxx", ucfirst($param), $content);
        $content = str_replace("xxx", strtolower($param), $content);
        $content = str_replace("XXX", strtoupper($param), $content);

        $content = str_replace("@id", $_ENV['CURRENT_AUTHOR'], $content);
        $content = str_replace("x.x.x", $_ENV['CURRENT_VERSION'], $content);

        return $content;
    }

    /**
     * Getting Class Name From File Name.
     * 
     * @since 1.0.0
     * 
     * @param string $fileName
     * 
     * @return string
     */
    private function getMigrationClassName(string $fileName): string
    {
        $fileName = ltrim(
            rtrim(
                preg_replace('/[0-9]+/', '', $fileName),
                '.php'
            ),
            '_'
        );

        while (strpos($fileName, '_')) {
            $underline = strpos($fileName, '_');
            $word = strtoupper($fileName[$underline + 1]);

            $fileName = substr_replace(
                $fileName, 
                $word, 
                $underline, 
                2
            );
        }

        return ucfirst($fileName);
    }
}
