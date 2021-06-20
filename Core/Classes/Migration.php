<?php

namespace Core\Classes;

use PDO;
use Core\Classes\CommandLineInterface as CLI;
use Core\Traits\Migration\{MigrationHelper as Helper, MigrationCommands as Commands};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Migration extends Database
{
    use Commands, Helper;

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
     * Running Up Method On Migration And Storing It Into Database.
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
     * Running Down Method On One Step Of Migrations And Deleting Them From Database.
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
     * Storing Applied Migration Into Migrations Table.
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
     * Deleting Migration Column From Migrations Table.
     * 
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
     * Getting Last Step Of Applied Migration Based On Batch Column.
     * 
     * @since 1.0.0
     * 
     * @param int $batchNumber
     * 
     * @return array
     */
    private function fetchLastBatch(int $batchNumber): array
    {
        $statement = $this->connection
            ->prepare("SELECT * FROM migrations WHERE batch=:batch");

        $statement->execute([
            'batch' => $batchNumber
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
