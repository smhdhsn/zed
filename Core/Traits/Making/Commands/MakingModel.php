<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\{CommandLineInterface as CLI, Str};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MakingModel
{
    /**
     * Making a Model With Given Information.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function model(array $params): string
    {
        if (! $params[1])
            return CLI::out('Please Enter A Name For Your Model !', CLI::RED);

        $fileName = ucfirst($params[1]);

        $templatePath = $this->templatePath('Model');
        $originPath = $this->originPath('App', 'Models', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = Str::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $fileName,
            '{%snake_case%}' => Str::pascalToSnake($fileName)
        ], $content);

        $this->createFile($originPath, $finalContent);

        return CLI::out("Model created successfully.", CLI::BLUE);
    }
}
