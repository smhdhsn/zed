<?php

namespace Core\Classes;

use Core\Traits\Migration\{MigrationHelper as Helper, MigrationCommands as Commands};
use Core\Classes\CommandLineInterface as CLI;
use PDO;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Migration extends Database
{
    use Commands, Helper;

    /**
     * Database connection.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $connection;

    /**
     * Creates an instance of this class.
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
     * Execute "up" method of the migration(s) and store the migration(s) of that step into database.
     * 
     * @since 1.0.0
     * 
     * @param string $migration
     * @param int $batchNumber
     * 
     * @return void
     */
    protected function forward(string $migration, int $batchNumber): void
    {
        echo CLI::out("Applying {$migration}", CLI::CYAN);
        $this->up();
        $this->store($migration, ++$batchNumber);
        echo CLI::out("Applied  {$migration}", CLI::BLUE);
    }

    /**
     * Execute "down" method on one step of migration(s) and delete migration(s) of that step from database.
     * 
     * @since 1.0.0
     * 
     * @param string $migration
     * 
     * @return void
     */
    protected function backward(string $migration): void
    {
        echo CLI::out("Dismissing {$migration}", CLI::RED);
        $this->down();
        echo CLI::out("Dismissed  {$migration}", CLI::PURPLE);
    }

    /**
     * Execute SQL command.
     * 
     * @since 1.0.0
     * 
     * @param string $sequel
     * 
     * @return void
     */
    protected function exec(string $sequel): void
    {
        $this->connection->exec($sequel);
    }

    /**
     * Store applied migration(s) into "migrations" table.
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
     * Delete migration(s) log from "migrations" table.
     * 
     * @since 1.0.0
     * 
     * @param string $columnName
     * @param mixed $value
     * 
     * @return void
     */
    private function destroyWhere(string $columnName, $value): void
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
     * Get last step of applied migration(s) based on batch number.
     * 
     * @since 1.0.0
     * 
     * @param int $batchNumber
     * 
     * @return array
     */
    private function fetchLastStep(int $batchNumber): array
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
     * Create "migrations" table to keep track of implemented migration files.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function createTable(): void
    {
        $this->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            batch INT
        ) ENGINE=INNODB;");
    }
}
