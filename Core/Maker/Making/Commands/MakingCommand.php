<?php

namespace Zed\Framework\Maker\Making\Commands;

use Zed\Framework\{CommandLineInterface as CLI, Str};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait MakingCommand
{
    /**
     * Making a Command With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function command(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Command !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $blueprint = $this->getBlueprint('Command');
        $originPath = $this->originPath('App', 'Commands', $fileName);

        $finalContent = Str::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $fileName,
        ], $blueprint);

        $this->createFile($finalContent, $originPath);

        return CLI::out("Command created successfully.", CLI::BLUE);
    }
}
