<?php

namespace Core\Traits\Making\Commands;

use Core\Classes\CommandLineInterface as CLI;

/**
 * @author @smhdhsn
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

        $templatePath = $this->templatePath('Command');
        $originPath = $this->originPath('App', 'Commands', $fileName);

        $content = $this->getContent($templatePath);

        $finalContent = $this->determineCommandType(
            $this->replacePlaceholders($content, $fileName),
            $this->params[2]
        );

        $this->createFile($originPath, $finalContent);

        $fileName = str_ireplace("Command", '', $fileName) .  ' - Command';

        return CLI::out("{$fileName} Created !", CLI::BLUE);
    }

    /**
     * Determine If The Command Is Open-Ended Or Close-Ended.
     * 
     * Open-Ended Commands Are The Type Of Commands Which Stay Awake Until The User
     * Forcefully Shuts Them Down Via Terminal.
     * 
     * Close-Ended Commands Are The Type Of Commands Which Will Be Automatically
     * Terminated When The Command's Execution Is Finished.
     * 
     * (Default Type Is Close-Ended).
     * 
     * @since 1.0.1
     * 
     * @param string $bluePrintContent
     * @param string|null $commandType
     * 
     * @return string
     */
    private function determineCommandType(string $bluePrintContent, ?string $commandType): string
    {
        switch ($commandType) {
            case '--open':
                return $this->replaceClassAndInterface([
                    'type' => 'OpenEndedCommand',
                    'abbreviation' => 'OEC',
                    'returning' => 'void',
                ], $bluePrintContent);

            case null:
            case '--close':
                return $this->replaceClassAndInterface([
                    'type' => 'CloseEndedCommand',
                    'abbreviation' => 'CEC',
                    'returning' => 'string',
                ], $bluePrintContent);

            default:
                echo CLI::out('Valid Command Types Are (--open, --close)', CLI::GREEN);
                echo CLI::out('Invalid Command Type !', CLI::BLINK_FAST . CLI::RED);
                die();
        }
    }

    /**
     * Modifying Interface To Use On Command.
     * 
     * @since 1.0.1
     * 
     * @param string $bluePrintContent
     * @param array $interfaceType
     * 
     * @return string
     */
    private function replaceClassAndInterface(array $interfaceType, string $bluePrintContent): string
    {
        $content = str_replace("#InterfaceType", $interfaceType['type'], $bluePrintContent);
        $content = str_replace("#InterfaceAbbreviation", $interfaceType['abbreviation'], $content);
        $finalContent = str_replace("#Returning", $interfaceType['returning'], $content);

        return $finalContent;
    }
}
