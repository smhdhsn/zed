<?php

namespace Zed\Framework;

use Zed\Framework\Model\QueryBuilder;
use ReflectionClass;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
abstract class Model
{
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
        $model = self::instantiateClass();

        return Application::$manager
            ->setTable($model->getTableName())
            ->setModel(get_called_class())
            ->where($column, $match);
    }

    /**
     * Fetch a column from database using their unique id.
     * 
     * @since 1.0.1
     * 
     * @param int $id
     * 
     * @return Model
     */
    public function find(int $id): Model
    {
        $model = self::instantiateClass();

        return Application::$manager
            ->setTable($model->getTableName())
            ->setModel(get_called_class())
            ->find($id);
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
        $model = self::instantiateClass();

        return Application::$manager
            ->setTable($model->getTableName())
            ->setModel(get_called_class())
            ->create($information);
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
        return Application::$manager
            ->setTable($this->getTableName())
            ->setId($this->id)
            ->update($information);
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
        return Application::$manager
            ->setTable($this->getTableName())
            ->setId($this->id)
            ->delete();
    }

    /**
     * Instantiate class.
     * 
     * @since 1.0.1
     * 
     * @return object
     */
    private static function instantiateClass(): Model
    {
        $class = get_called_class();

        return new $class();
    }

    /**
     * Get model's table name from property "table" inside model's instance.
     * If it's not defined, it'll be gotten from reflection class on called
     * class's instance.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    private function getTableName(): string
    {
        if ($this->table)
            return $this->table;

        return strtolower((new ReflectionClass(get_called_class()))->getShortName());
    }
}
