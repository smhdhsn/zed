<?php

namespace Zed\Framework\Database;

use Zed\Framework\Model\Contract\ObjectRelationalMapping;
use Zed\Framework\Model\{QueryBuilder, Manager};
use Zed\Framework\Database\Contract\Manageable;
use Zed\Framework\Exception\DatabaseException;
use Zed\Framework\Model\Manager\MysqlManager;
use Zed\Framework\Database\Platform\MySQL;
use Zed\Framework\Database;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class DatabaseManager implements Manageable
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
     * Get proper database instance based on "DB_CONNECTION" environment variable.
     * 
     * @since 1.0.1
     * 
     * @throws DatabaseException if "DB_CONNECTION" environment variable contains unknown database.
     * 
     * @return object
     */
    public function getDatabase(): Database
    {
        switch ($this->type) {
            case 'mysql':
                return new MySQL;

            default:
                throw new DatabaseException;
        }
    }

    /**
     * Get proper database manager based on "DB_CONNECTION" environment variable.
     * 
     * @since 1.0.1
     * 
     * @throws DatabaseException if "DB_CONNECTION" environment variable contains unknown database.
     * 
     * @return ObjectRelationalMapping
     */
    public function getManager(): ObjectRelationalMapping
    {
        switch ($this->type) {
            case 'mysql':
                return new Manager(new MysqlManager(new QueryBuilder));

            default:
                throw new DatabaseException;
        }
    }
}
