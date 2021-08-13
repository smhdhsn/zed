<?php

namespace Core\Traits\Migration;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MigrationHelper
{
    /**
     * Getting Files Inside Migration Folder.
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function getFiles(): array
    {
        return scandir($this->getPath());
    }

    /**
     * Getting Migrations That Need To Be Applied.
     * (Removes "." And ".." From scandir's Result)
     * 
     * @since 1.0.0
     * 
     * @param array $applied
     * @param array $files
     * 
     * @return array
     */
    private function getToApply(array $applied, array $files): array
    {
        return array_splice(
            array_diff($files, $applied),
            2
        );
    }
    
    /**
     * Getting Migration File Inside Migration Folder.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function getFile(string $fileName): string
    {
        return $this->getPath()
        . DIRECTORY_SEPARATOR
        . $fileName;
    }

    /**
     * Getting Path To The Folder That Contains Migration Files.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function getPath(): string
    {
        return dirname(__DIR__, 3)
        . DIRECTORY_SEPARATOR
        . 'Database'
        . DIRECTORY_SEPARATOR
        . 'Migrations';
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
    private function getClassName(string $fileName): string
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
