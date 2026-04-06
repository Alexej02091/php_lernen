<?php
class DataSeeder{
    private DB $db;

    public function __construct(DB $db) {
        $this->db = $db;
    }

    public function insertAdmin(): void {
    $this->db->query(
            "CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            rolle VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );
    $this->db->query(
            "INSERT IGNORE INTO user (id, name, pass, rolle)",
            [1, $name, password_hash($pass, PASSWORD_DEFAULT), rolle]
        );
    }
    
}
?>