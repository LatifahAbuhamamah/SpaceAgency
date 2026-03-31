<?php
/**
 * db.php — MySQL Database Connection
 *
 * Change the 4 values below to match your MySQL server.
 * This file is included by contact.php.
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'space_db');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDB(): PDO {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    return $pdo;
}
