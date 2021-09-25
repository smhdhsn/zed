<?php

namespace Zed\Framework\Model\Manager;

use Zed\Framework\Model\Contract\ObjectRelationalMapping as ORM;
use Zed\Framework\Model\{QueryBuilder, Manager};
use Zed\Framework\Exception\NotFoundException;
use Zed\Framework\{Application, Model};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class MysqlManager implements ORM
{
    /**
     * Manager context's instance.
     * 
     * @since 1.0.1
     * 
     * @var Manager
     */
    private Manager $context;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param QueryBuilder $builder
     * 
     * @return void
     */
    public function __construct(QueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Receive context and store it into a variable.
     * 
     * @since 1.0.1
     * 
     * @param Manager $context
     * 
     * @return MysqlManager
     */
    public function setContext(Manager $context): MysqlManager
    {
        $this->context = $context;

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
     * @return QueryBuilder
     */
    public function where(string $column, string $match): QueryBuilder
    {
        $query = "SELECT * FROM \n\t{$this->context->table} \nWHERE \n\t{$column}=:{$column}";

        $this->builder->setQuery($query)
            ->setParams([$column => $match])
            ->setModel($this->context->model);

        return $this->builder;
    }

    /**
     * Fetch a column from database using their unique id.
     * 
     * @since 1.0.1
     * 
     * @param int $id
     * 
     * @throws NotFoundException if record not found.
     * 
     * @return Model
     */
    public function find(int $id): Model
    {
        $query = "SELECT * FROM \n\t{$this->context->table} \nWHERE \n\tid=:id";

        $this->builder->setQuery($query)
            ->setParams(['id' => $id])
            ->setModel($this->context->model)
            ->prepare()
            ->execute();

        $result = $this->builder->getOne();

        if (is_bool($result))
            throw new NotFoundException;

        return $result;
    }

    /**
     * Create a model and store it into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return Model
     */
    public function create(array $information): Model
    {
        $queryMaker = function ($information, $prefix = null) {
            return implode(
                ',',
                array_map(function ($key, $value) use ($prefix) {
                    return "\n\t{$prefix}{$key}";
                }, array_keys($information), $information)
            );
        };

        $query = "INSERT INTO \n{$this->context->table}({$queryMaker($information)}\n) \nVALUES({$queryMaker($information, ':')}\n);";

        $this->builder->setQuery($query)
            ->setParams($information)
            ->setModel($this->context->model)
            ->prepare()
            ->execute();

        return $this->find($this->builder->lastInsertion());
    }

    /**
     * Update a model's information and store them into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return bool
     */
    public function update(array $information): bool
    {
        $queryMaker = function ($information) {
            return implode(
                ',',
                array_map(function ($key, $value) {
                    return "\n\t{$key}=:{$key}";
                }, array_keys($information), $information)
            );
        };

        $query = "UPDATE \n\t{$this->context->table} \nSET {$queryMaker($information)} \nWHERE \n\tid=:id;";
        $params = array_merge($information, ['id' => $this->context->modelId]);

        return $this->builder->setQuery($query)
            ->setParams($params)
            ->setModel($this->context->model)
            ->prepare()
            ->execute();
    }

    /**
     * Delete a model from database.
     * 
     * @since 1.0.1
     * 
     * @return bool
     */
    public function delete(): bool
    {
        $query = "DELETE FROM \n\t{$this->context->table} \nWHERE \n\tid=:id";

        return $this->builder->setQuery($query)
            ->setParams(['id' => $this->context->modelId])
            ->setModel($this->context->model)
            ->prepare()
            ->execute();
    }
}
