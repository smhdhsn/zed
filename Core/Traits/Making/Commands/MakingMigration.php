<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingMigration
{
    /**
     * Making a Migration With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function migration(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Migration !', CLI::RED);

        $date = date('Y_m_d_') . (time() % 86400) . '_';
        $fileName = $date . $params[1];
        $className = $this->getMigrationClassName($fileName);

        $templatePath = $this->templatePath('Migration');
        $originPath = $this->originPath('Database', 'Migrations', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = $this->replacePlaceholders($content, $className);

        $this->createFile($originPath, $finalContent);

        return CLI::out("{$fileName} Created !", CLI::BLUE);
    }
}
