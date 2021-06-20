<?php

namespace Core\Classes;

use PDO;
use Core\Traits\Migration\MigrationHelper as Helper;
use Core\Traits\Migration\Commands\{Migrate, Rollback, Fresh, Reset};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Migration extends Database
{
    use Migrate, Rollback, Fresh, Reset, Helper;

    /**
     * Database Connection.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $connection;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = $this->connect();
        $this->createTable();
    }

    /**
     * Storing Applied Migration.
     * 
     * @since 1.0.0
     * 
     * @param string $fileName
     * @param int $batchNumber
     * 
     * @return void
     */
    private function store(string $fileName, int $batchNumber): void
    {
        $statement = $this->connection->prepare("INSERT INTO migrations(migration, batch) VALUES(:migration,:batch)");

        $statement->execute([
            'migration' => "{$fileName}.php",
            'batch' => $batchNumber,
        ]);
    }

    /**
     * Getting Last Batch Number Of Migrations.
     * (Returns "0" If Migrations Table Is Empty)
     * 
     * @since 1.0.0
     * 
     * @return int
     */
    private function lastBatch(): int
    {
        $statement = $this->connection
            ->prepare("SELECT MAX(batch) FROM migrations");

        $statement->execute();

        return $statement->fetchColumn() ?? 0;
    }

    /**
     * Getting Applied Migrations.
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function getApplied(): array
    {
        $statement = $this->connection
            ->prepare("SELECT migration FROM migrations");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Creating Migration Table To Keep Track Of Implemented Migration Files.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function createTable(): void
    {
        $this->connection->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            batch INT
        ) ENGINE=INNODB;");
    }
}
