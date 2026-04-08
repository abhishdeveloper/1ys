<?php
/**
 * Database Configuration & Connection Logic
 * Uses PDO for secure database access.
 */

// Define environment: 'development' or 'production'
define('ENVIRONMENT', 'production');

// Define database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');
define('DB_CHARSET', 'utf8mb4');

/**
 * Get a PDO database connection.
 *
 * @return PDO
 * @throws Exception if connection fails
 */
function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // In a production environment, log the error rather than displaying it to the user.
            // For now, we halt execution and display a generic message.
            error_log("Database Connection Error: " . $e->getMessage());
            die("Critical Error: Unable to connect to the database. Please check your configuration.");
        }
    }

    return $pdo;
}
?>