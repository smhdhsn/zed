<?php

namespace Zed\Framework\Database\Contract;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface Connectable
{
    /**
     * Every connectable class must provide a method that sets database connection
     * and returns connected database's instance containing database connection within 
     * the class.
     * 
     * @since 1.0.1
     * 
     * @return object
     */
    public function getDatabase(): object;
}