<?php

namespace Zed\Framework\Maker;

use Zed\Framework\Maker\Protocol\Makeable;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Maker implements Makeable
{
    /**
     * Maker strategy's instance.
     * 
     * @since 1.0.1
     * 
     * @var Makeable
     */
    private Makeable $strategy;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct(Makeable $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Set a filename for the file that is being created.
     * 
     * @since 1.0.1
     * 
     * @param string $filename
     * 
     * @return Makeable
     */
    public function setFilename(string $filename): Makeable
    {
        $this->strategy->setFilename($filename);

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
        $this->strategy->getBlueprint();

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
        $this->strategy->getDestination();

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
        $this->strategy->fillPlaceholders();

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
        $this->strategy->createFile();

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
        return $this->strategy->getMessage();
    }
}
