<?php
class DBCheck {

    public static function check($db) {
        $conn = $db->connect();

        // 1. DB nicht erreichbar → Fallback prüfen
        if ($conn === false) {

            $fallbackFile = __DIR__ . '/fallback/users.json';

            if (!file_exists($fallbackFile)) {
                $_SESSION["db_status"] = [
                    "ok" => false,
                    "message" => "Keine Verbindung zur Datenbank und kein Fallback verfügbar."
                ];
                return false;
            }

            // Fallback existiert → OK
            $_SESSION["db_status"] = [
                "ok" => false,
                "message" => "Datenbank nicht erreichbar - Fallback-Daten werden genutzt."
            ];

            return true;
        }

        // 2. DB liefert Array → Fallback aktiv
        if (is_array($conn)) {
            $_SESSION["db_status"] = [
                "ok" => false,
                "message" => "Datenbank nicht erreichbar - Fallback-Daten werden genutzt."
            ];
            return true;
        }

        // 3. DB erfolgreich
        $_SESSION["db_status"] = [
            "ok" => true,
            "message" => "Verbindung zur Datenbank erfolgreich."
        ];

        self::checkUsersTable($db);

        return true;
    }

    private static function checkUsersTable($db) {
        $sql = "SHOW TABLES LIKE 'users'";
        $result = $db->query($sql);

        if ($result === "") {
            // Tabelle existiert NICHT → erstellen
            self::createUsersTable($db);
        }

        // Admin prüfen
        self::checkAdminUser($db);
    }

    private static function createUsersTable($db) {
        $sql = "
            CREATE TABLE `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `rolle` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $db->query($sql);
    }

    private static function checkAdminUser($db) {

        // Passwort sicher hashen
        $hashedPassword = password_hash("admin", PASSWORD_DEFAULT);

        // Prüfen, ob Admin existiert
        $sql = "SELECT * FROM users WHERE id = 1 AND name='admin' AND rolle='admin'";
        $result = $db->query($sql);

        if ($result === "") {
            // Admin existiert nicht → einfügen
            $sql = "
                INSERT INTO users (id, name, password, rolle)
                VALUES (1, 'admin', '{$hashedPassword}', 'admin')
                ON DUPLICATE KEY UPDATE password='{$hashedPassword}';
            ";
            $db->query($sql);
        }
    }


}
