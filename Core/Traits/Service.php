<?php

namespace Core\Traits;

/**
 * @author @smhdhsn
 * 
 * @since 1.0.0
 */
trait Service
{
    /**
     * Related Model's Repository.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private $repository;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $model = explode('\\', substr(self::class, 13))[0];

        $class = "\\App\\Repositories\\{$model}Repository";

        $this->repository = new $class();
    }
}
