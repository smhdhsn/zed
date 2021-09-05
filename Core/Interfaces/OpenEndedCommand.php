<?php

namespace Core\Interfaces;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
interface OpenEndedCommand
{
    /**
     * Every Command Must Have handle() Method Which Is Responsible 
     * For Executing The Command's Action. Open-Ended Commands Must
     * Restrict Return Type Of The handle() Method To Be Type Of
     * Void, Because an Open-Ended Command Won't Return Anything.
     */
    public function handle(): void;
}
