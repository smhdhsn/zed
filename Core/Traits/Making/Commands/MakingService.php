<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingService
{
    /**
     * Making a Repository With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function service(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Service !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $templatePath = $this->templatePath('Service');
        $originPath = $this->originPath('App', 'Services', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = $this->replacePlaceholders($content, $fileName);

        $this->createFile($originPath, $finalContent);

        $fileName = trim($fileName, 'Service') . ' - Service';

        return CLI::out("{$fileName} Created !", CLI::BLUE);
    }
}
