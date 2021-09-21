<?php

namespace Zed\Framework\Maker\Making;

use Zed\Framework\Maker\Making\Commands\{MakingCommand as Command, MakingController as Controller, MakingMigration as Migration, MakingModel as Model, MakingRepository as Repository, MakingService as Service};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait MakingCommands
{
    use Command, Controller, Migration, Model, Repository, Service;
}
