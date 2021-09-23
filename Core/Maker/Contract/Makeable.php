<?php

namespace Zed\Framework\Maker\Contract;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface Makeable
{
    /**
     * Set a filename for the file that is being created.
     * 
     * @since 1.0.1
     * 
     * @param string $filename
     * 
     * @return Makeable
     */
    public function setFilename(string $filename): Makeable;

    /**
     * Get related blueprint.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function getBlueprint(): Makeable;

    /**
     * Get the path where the file that is being created will be placed.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function getDestination(): Makeable;

    /**
     * Fill in the related blueprint's placeholder(s) with proper value(s).
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function fillPlaceholders(): Makeable;

    /**
     * Create the file.
     * 
     * @since 1.0.1
     * 
     * @return Makeable
     */
    public function createFile(): Makeable;

    /**
     * Get proper message for showing in terminal.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function getMessage(): string;
}
