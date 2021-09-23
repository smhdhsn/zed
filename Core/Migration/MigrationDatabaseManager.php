<?php

namespace Zed\Framework\Migration;

use Zed\Framework\Application;
use PDO;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class MigrationDatabaseManager
{
    /**
     * Database connection.
     * 
     * @since 1.0.1
     * 
     * @var object
     */
    private object $connection;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = Application::$database->getConnection();
    }

    /**
     * Execute SQL command.
     * 
     * @since 1.0.1
     * 
     * @param string $query
     * 
     * @return void
     */
    public function exec(string $query): void
    {
        $this->connection->exec($query);
    }

    /**
     * Store applied migration(s) into "migrations" table.
     * 
     * @since 1.0.1
     * 
     * @param string $fileName
     * @param int $batchNumber
     * 
     * @return void
     */
    public function store(string $fileName, int $batchNumber): void
    {
        $statement = $this->connection->prepare("INSERT INTO migrations(migration, batch) VALUES(:migration,:batch)");

        $statement->execute([
            'migration' => $fileName,
            'batch' => $batchNumber,
        ]);
    }

    /**
     * Delete migration(s) log from "migrations" table.
     * 
     * @since 1.0.1
     * 
     * @param string $columnName
     * @param mixed $value
     * 
     * @return void
     */
    public function destroyWhere(string $columnName, $value): void
    {
        $statement = $this->connection->prepare("DELETE FROM migrations WHERE {$columnName}=:{$columnName}");

        $statement->execute([
            $columnName => $value,
        ]);
    }

    /**
     * Get last batch number of migrations.
     * (Returns "0" if "migrations" table is empty)
     * 
     * @since 1.0.1
     * 
     * @return int
     */
    public function lastBatch(): int
    {
        $statement = $this->connection
            ->prepare("SELECT MAX(batch) FROM migrations");

        $statement->execute();

        return $statement->fetchColumn() ?? 0;
    }

    /**
     * Get last step of applied migration(s) based on batch number.
     * 
     * @since 1.0.1
     * 
     * @param int $batchNumber
     * 
     * @return array
     */
    public function fetchLastStep(int $batchNumber): array
    {
        $statement = $this->connection
            ->prepare("SELECT * FROM migrations WHERE batch=:batch");

        $statement->execute([
            'batch' => $batchNumber
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get applied migration(s).
     * 
     * @since 1.0.1
     * 
     * @return array
     */
    public function getApplied(): array
    {
        $statement = $this->connection
            ->prepare("SELECT migration FROM migrations");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
}
