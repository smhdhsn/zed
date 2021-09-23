<?php

namespace Database\Migrations;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class CreateUsersTable
{
    /**
     * Apply some changes to a certain table.
     * 
     * @since 1.0.1
     * 
     * @return array
     */
    public function up(): array
    {
        return [
            'CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                surname VARCHAR(255) NOT NULL, 
                username VARCHAR(255) NOT NULL UNIQUE,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                phone_number VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB'
        ];
    }

    /**
     * Unapply some changes to a certain table.
     * 
     * @since 1.0.1
     * 
     * @return array
     */
    public function down(): array
    {
        return [
            'DROP TABLE IF EXISTS users'
        ];
    }
}
