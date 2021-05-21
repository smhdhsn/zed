<?php

/**
 * Loading Environment Variables.
 */
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))
    ->load();
