<?php

namespace Core\Traits;

/**
 * @author @smhdhsn
 * 
 * @since 1.2.0
 */
trait Repository
{
    /**
     * Repositorie's Model.
     * 
     * @since 1.2.0
     * 
     * @var object
     */
    private $model;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.2.0
     * 
     * @return void
     */
    public function __construct()
    {
        $model = substr(self::class, 17, -10);

        $class = "\\App\\Models\\{$model}";

        $this->model = new $class();
    }
}