<?php

namespace Zed\Framework\Model;

use Zed\Framework\Model\Contract\ObjectRelationalMapping as ORM;
use Zed\Framework\Exception\QueryException;
use Zed\Framework\Model\QueryBuilder;
use Zed\Framework\Model;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Manager implements ORM
{
    /**
     * Manager's strategy.
     * 
     * @since 1.0.1
     * 
     * @var ORM
     */
    private ORM $orm;

    /**
     * Model's class.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    public string $model;

    /**
     * Model's unique id.
     * 
     * @since 1.0.1
     * 
     * @var int
     */
    public int $modelId;

    /**
     * Model's table name.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    public string $table;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param ORM $orm
     * 
     * @return void
     */
    public function __construct(ORM $orm)
    {
        $this->orm = $orm;
        $this->orm->setContext($this);
    }

    /**
     * Save model's instance inside manager's scope.
     * 
     * @since 1.0.1
     * 
     * @param string $model
     * 
     * @return Manager
     */
    public function setModel(string $model): Manager
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Save model's unique id inside manager's scope.
     * 
     * @since 1.0.1
     * 
     * @param string $modelId
     * 
     * @return Manager
     */
    public function setId(int $modelId): Manager
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Save model's table name inside manager's scope.
     * 
     * @since 1.0.1
     * 
     * @param string $table
     * 
     * @return Manager
     */
    public function setTable(string $table): Manager
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Fetch column(s) from database using a key value pairs.
     * 
     * @since 1.0.1
     * 
     * @param string $column
     * @param string $match
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * 
     * @return QueryBuilder
     */
    public function where(string $column, string $match): QueryBuilder
    {
        try {
            return $this->orm->where($column, $match);
        } catch (Exception $exception) {
            throw new QueryException;
        }
    }

    /**
     * Fetch a column from database using their unique id.
     * 
     * @since 1.0.1
     * 
     * @param int $id
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * 
     * @return Model
     */
    public function find(int $id): Model
    {
        try {
            return $this->orm->find($id);
        } catch (Exception $exception) {
            throw new QueryException;
        }
    }

    /**
     * Create a model and store it into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * 
     * @return Model
     */
    public function create(array $information): Model
    {
        try {
            return $this->orm->create($information);
        } catch (Exception $exception) {
            throw new QueryException;
        }
    }

    /**
     * Update a model's information and store them into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * 
     * @return bool
     */
    public function update(array $information): bool
    {
        try {
            return $this->orm->update($information);
        } catch (Exception $exception) {
            throw new QueryException;
        }
    }

    /**
     * Delete a model from database.
     * 
     * @since 1.0.1
     * 
     * @throws QueryException if anything goes wrong while executing the query.
     * 
     * @return bool
     */
    public function delete(): bool
    {
        try {
            return $this->orm->delete();
        } catch (Exception $exception) {
            throw new QueryException;
        }
    }
}
