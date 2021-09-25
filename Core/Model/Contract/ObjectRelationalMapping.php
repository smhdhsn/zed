<?php

namespace Zed\Framework\Model\Contract;

use Zed\Framework\Model\{QueryBuilder, Collection, Manager};
use Zed\Framework\Model;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface ObjectRelationalMapping
{
    /**
     * Every ORM must provide a method to fetch a column from database using their
     * unique id.
     * 
     * @since 1.0.1
     * 
     * @param int $id
     * 
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * Every ORM must provide a method to fetch column(s) from database using a key
     * value pairs.
     * 
     * @since 1.0.1
     * 
     * @param string $column
     * @param string $match
     * 
     * @return QueryBuilder
     */
    public function where(string $column, string $match): QueryBuilder;

    /**
     * Every ORM must provide a method to create a model and store it into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return Model
     */
    public function create(array $information): Model;

    /**
     * Every ORM must provide a method to update a model's information and store them 
     * into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return bool
     */
    public function update(array $information): bool;

    /**
     * Every ORM must provide a method to delete a model from database.
     * 
     * @since 1.0.1
     * 
     * @return bool
     */
    public function delete(): bool;
}
