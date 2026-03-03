<?php
/**
 * User Model
 * Handles database operations for the `users` table.
 */
class User {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Find a user by their email.
     *
     * @param string $email
     * @return array|false Returns user data or false if not found
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Register a new user in the database.
     *
     * @param string $name
     * @param string $email
     * @param string $password The raw, unhashed password
     * @param string $phone Optional phone number
     * @param string $address Optional address
     * @return int|false Returns the new user's ID or false on failure
     */
    public function create($name, $email, $password, $phone = null, $address = null) {
        // Hash the password securely using PHP's native function
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Standard users are 'customer' role by default
        $role = 'customer';

        $stmt = $this->db->prepare("
            INSERT INTO users (role, name, email, password_hash, phone, address)
            VALUES (:role, :name, :email, :password_hash, :phone, :address)
        ");

        try {
            $stmt->execute([
                'role' => $role,
                'name' => $name,
                'email' => $email,
                'password_hash' => $hash,
                'phone' => $phone,
                'address' => $address
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Handle duplicate email (UNIQUE constraint violation)
            if ($e->getCode() == 23000) {
                return false; // Email already exists
            }
            throw $e;
        }
    }
}
?>