<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\{CommandLineInterface as CLI, Str};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingRepository
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
    protected function repository(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Repository !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $templatePath = $this->templatePath('Repository');
        $originPath = $this->originPath('App', 'Repositories', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = Str::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $fileName,
        ], $content);

        $this->createFile($originPath, $finalContent);

        return CLI::out("Repository created successfully.", CLI::BLUE);
    }
}
