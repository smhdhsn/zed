<?php

namespace Core\Classes;

use PDO;
use App\Models\Migration as Model;
use Core\Classes\CommandLineInterface as CLI;
use Core\Traits\Migration\MigrationHelper as Helper;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Migration extends Database
{
    use Helper;

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
     * Applying Migration Files.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function apply(): string
    {
        $batch = $this->lastBatch();
        $migrations = $this->getToApply(
            $this->getApplied(), 
            $this->getFiles()
        );

        if (empty($migrations))
            return CLI::out('Nothing To Migrate !', CLI::BLINK_FAST);

        foreach ($migrations as $migration) {
            require_once $this->getFile($migration);
            
            $className = $this->getClassName($migration);
            $class = "\\Database\\Migrations\\$className";

            $object = new $class();
            $object->forward(rtrim($migration, '.php'), $batch);
        }

        return CLI::out('All Files Migrated !', CLI::BLINK_FAST);
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
    protected function forward(string $migration, int $batch): void
    {
        echo CLI::out("Applying {$migration}", CLI::CYAN);
        $this->up();
        $this->store($migration, $batch);
        echo CLI::out("Applied  {$migration}", CLI::BLUE);
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

        return 1 + $statement->fetchColumn();
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
