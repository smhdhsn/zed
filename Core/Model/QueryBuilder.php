<?php

namespace Zed\Framework\Model;

use Zed\Framework\Exception\{QueryException, NotFoundException};
use Zed\Framework\Model\Collection;
use Zed\Framework\Application;
use Exception;
use PDO;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class QueryBuilder
{
    /**
     * SQL query.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    private string $query;

    /**
     * Query param(s).
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $params = [];

    /**
     * Prepared statement.
     * 
     * @since 1.0.1
     * 
     * @var object
     */
    private object $statement;

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
     * Store query in this scope.
     * 
     * @since 1.0.1
     * 
     * @param string $query
     * 
     * @return QueryBuilder
     */
    public function setQuery(string $query): QueryBuilder
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Store parameter(s) in this scope.
     * 
     * @since 1.0.1
     * 
     * @param array $params
     * 
     * @return QueryBuilder
     */
    public function setParams(array $params): QueryBuilder
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Store model in this scope.
     * 
     * @since 1.0.1
     * 
     * @param string $model
     * 
     * @return QueryBuilder
     */
    public function setModel(string $model): QueryBuilder
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Preparing query for execution.
     * 
     * @since 1.0.1
     * 
     * @return QueryBuilder
     */
    public function prepare(): QueryBuilder
    {
        $this->statement = $this->connection->prepare($this->query);

        return $this;
    }

    /**
     * Executing the query.
     * 
     * @since 1.0.1
     * 
     * @return bool
     */
    public function execute(): bool
    {
        return $this->statement->execute($this->params);
    }

    /**
     * Fetch object with type of provided model.
     * 
     * @since 1.0.1
     * 
     * @return object|bool
     */
    public function getOne()
    {
        return $this->statement->fetchObject($this->model);
    }

    /**
     * Fetch an array of objects with type of provided model.
     * 
     * @since 1.0.1
     * 
     * @return array
     */
    public function getMany(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    /**
     * Fetch last inserted column's unique id.
     * 
     * @since 1.0.1
     * 
     * @return int
     */
    public function lastInsertion(): int
    {
        return (int) $this->connection
            ->query("SELECT LAST_INSERT_ID()")
            ->fetchColumn();
    }

    /**
     * Fetch column(s) from database after a series of filters has been applied to the query.
     * 
     * @since 1.0.1
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * @throws NotFoundException if record not found.
     * 
     * @return Collection
     */
    public function get(): Collection
    {
        $this->prepare();

        if ($this->execute()) {
            if (empty($data = $this->getMany()))
                throw new NotFoundException;

            return new Collection($data);
        }

        throw new QueryException;
    }
}
