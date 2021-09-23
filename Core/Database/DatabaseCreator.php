<?php

namespace Zed\Framework\Database;

use Zed\Framework\Database\Contract\Connectable;
use Zed\Framework\Database\Platform\MySQL;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class DatabaseCreator implements Connectable
{
    /**
     * Database type.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $type;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct()
    {
        $this->type = strtolower(
            $_ENV['DB_CONNECTION']
        );
    }

    /**
     * Get proper database based on "DB_CONNECTION" environment variable.
     * 
     * @since 1.0.1
     * 
     * @throws Exception if "DB_CONNECTION" environment variable contains unknown database.
     * 
     * @return object
     */
    public function getDatabase(): object
    {
        switch ($this->type) {
            case 'mysql':
                return new MySQL;

            default:
                throw new Exception('Unknown database.');
        }
    }
}
