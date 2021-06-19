<?php

namespace Core\Interfaces;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
interface Console
{
    /**
     * Every Command Must Have handle() Method Which Is Responsible 
     * For Executing The Command's Action And Returning Message
     * That Will Be Outputed To Terminal.
     */
    public function handle(): string;
}
