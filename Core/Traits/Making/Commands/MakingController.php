<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingController
{
    /**
     * Making a Controller With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function controller(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Controller !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $templatePath = $this->templatePath('Controller');
        $originPath = $this->originPath('Controllers', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = $this->replacePlaceholders($content, $fileName);

        $this->createFile($originPath, $finalContent);

        return CLI::out("{$fileName} Controller Created !", CLI::BLUE);
    }
}
