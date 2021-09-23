<?php

namespace Zed\Framework\Maker\Strategy;

use Zed\Framework\{Application, CommandLineInterface as CLI, File};
use Zed\Framework\Maker\Contract\Makeable;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class ControllerMaker implements Makeable
{
    /**
     * Final content of the file.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $content;

    /**
     * Filename.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $filename;

    /**
     * File's blueprint.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $blueprint;

    /**
     * Destination of the file.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $destination;

    /**
     * Set a filename for the file that is being created.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function setFilename(string $filename): Makeable
    {
        $this->filename = ucfirst($filename);

        return $this;
    }

    /**
     * Get content of the related blueprint.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function getBlueprint(): Makeable
    {
        $this->blueprint = File::getFileContent(
            Application::$path['blueprints'] . '/Controller.txt'
        );

        return $this;
    }

    /**
     * Get the path where the file that is being created will be placed.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function getDestination(): Makeable
    {
        $this->destination = Application::$path['controllers'] . "/{$this->filename}.php";

        return $this;
    }

    /**
     * Fill in the related blueprint's placeholder(s) with proper value(s).
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function fillPlaceholders(): Makeable
    {
        $this->content = File::placeValue([
            '{%author%}' => '@' . ltrim($_ENV['CURRENT_AUTHOR'], '@'),
            '{%version%}' => $_ENV['CURRENT_VERSION'],
            '{%PascalCase%}' => $this->filename,
        ], $this->blueprint);

        return $this;
    }

    /**
     * Create the file.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function createFile(): Makeable
    {
        File::createFile($this->content, $this->destination);

        return $this;
    }

    /**
     * Get proper message for showing in terminal.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return CLI::out("Controller created successfully.", CLI::BLUE);
    }
}
