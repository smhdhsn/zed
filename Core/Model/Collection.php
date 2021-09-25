<?php

namespace Zed\Framework\Model;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Collection implements Countable, Iterator, ArrayAccess
{
    /**
     * The items contained in the collection.
     *
     * @since 1.0.1
     * 
     * @var array
     */
    private array $items = [];

    /**
     * Position of iterator's cursor.
     * 
     * @since 1.0.1
     * 
     * @var int
     */
    private int $position = 0;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param array $items
     * 
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Provides support for counting the items within collection.
     * (Implementation of method declared in "Countable" interface)
     * 
     * @since 1.0.1
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Resets the internal cursor to the beginning of the array.
     * (Implementation of method declared in ""Iterator"" interface)
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Used to get the current key in a foreach() structure.
     * (Implementation of method declared in ""Iterator"" interface)
     * 
     * @since 1.0.1
     * 
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Used to get the value at the current cursor position.
     * (Implementation of method declared in "Iterator" interface)
     * 
     * @since 1.0.1
     * 
     * @return mixed
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * Used to move the cursor to the next position.
     * (Implementation of method declared in "Iterator" interface)
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Checks if the current cursor position is valid.
     * (Implementation of method declared in "Iterator" interface)
     * 
     * @since 1.0.1
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Used to be check if an offset exists in the collection.
     * (Implementation of method declared in "ArrayAccess" interface)
     * 
     * @since 1.0.1
     * 
     * @param mixed $offset
     * 
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * Used for accessing array-like to the collection "$collection[$offset]".
     * (Implementation of method declared in "ArrayAccess" interface)
     * 
     * @since 1.0.1
     * 
     * @param mixed $offset
     * 
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Used for setting a value into the collection directly.
     * (Implementation of method declared in "ArrayAccess" interface)
     * 
     * @since 1.0.1
     * 
     * @param null|mixed $offset
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (empty($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Used for unsetting a value from the collection.
     * (Implementation of method declared in "ArrayAccess" interface)
     * 
     * @since 1.0.1
     * 
     * @param mixed $offset
     * 
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
