<?php

namespace Zed\Framework\Maker\Making\Commands;

use Zed\Framework\{CommandLineInterface as CLI, Str};

/**
 * @author @SMhdHsn
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

        $blueprint = $this->getBlueprint('Repository');
        $originPath = $this->originPath('App', 'Repositories', $fileName);

        $finalContent = Str::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $fileName,
        ], $blueprint);

        $this->createFile($finalContent, $originPath);

        return CLI::out("Repository created successfully.", CLI::BLUE);
    }
}
