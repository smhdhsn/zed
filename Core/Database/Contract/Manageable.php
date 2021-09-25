<?php

namespace Zed\Framework\Database\Contract;

use Zed\Framework\Model\Contract\ObjectRelationalMapping;
use Zed\Framework\Database;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface Manageable
{
    /**
     * Every database manager class must provide a method to return a database
     * instance that provides a way to connect to a specific database.
     * 
     * @since 1.0.1
     * 
     * @return object
     */
    public function getDatabase(): Database;

    /**
     * Every database manager class must provide a method to return a database
     * manager instance that provides a way to interact with a specific database.
     * 
     * @since 1.0.1
     * 
     * @return ObjectRelationalMapping
     */
    public function getManager(): ObjectRelationalMapping;
}
