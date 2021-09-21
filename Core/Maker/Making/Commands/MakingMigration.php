<?php

namespace Zed\Framework\Maker\Making\Commands;

use Zed\Framework\{CommandLineInterface as CLI, Str};

/**
 * @author @SMhdHsn
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

        $className = Str::snakeToPascal($params[1]);

        $blueprint = $this->getBlueprint('Migration');
        $originPath = $this->originPath('Database', 'Migrations', $fileName);

        $finalContent = Str::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $className,
        ], $blueprint);

        $this->createFile($finalContent, $originPath);

        return CLI::out("Created Migration: " . CLI::WHITE . $fileName, CLI::BLUE);
    }
}
