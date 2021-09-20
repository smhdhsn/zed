<?php

namespace Core\Traits\Making;

use Core\Traits\Making\Commands\{MakingCommand as Command, MakingController as Controller, MakingMigration as Migration, MakingModel as Model, MakingRepository as Repository, MakingService as Service};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait MakingCommands
{
    use Command, Controller, Migration, Model, Repository, Service;
}
