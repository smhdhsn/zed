<?php

namespace Core\Interfaces;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
interface CloseEndedCommand
{
    /**
     * Every Command Must Have handle() Method Which Is Responsible 
     * For Executing The Command's Action. Close-Ended Commands Must
     * Restrict Return Type Of The handle() Method To Be Type Of
     * String, So That a Message Could Be Echoed Out In Terminal After
     * The Action Is Done.
     */
    public function handle(): string;
}
