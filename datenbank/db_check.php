<?php
class DBCheck {

    public static function check($db) {

        $fallbackFile = __DIR__ . '/fallback/users.json';
        $fallbackData = null;

        // 1. DB-Verbindung prüfen
        $conn = $db->connect();

        if ($conn === false) {
            $_SESSION["db_status"] = [
                "ok" => false,
                "message" => "Keine DB-Verbindung"
            ];
        } else {
            $_SESSION["db_status"] = [
            "ok" => true,
            "message" => "Verbindung zur Datenbank erfolgreich."
            ];

            // Alle Daten von DB holen
            // Tabellen Namen 
            // Attributen der Tabellen
            // Eingeschaften der Attributen
            // 
        }

        // 1. Fallback prüfen
        if (file_exists($fallbackFile)) {
            $json = file_get_contents($fallbackFile);
            $fallbackData = json_decode($json, true);

            $_SESSION["fallback_status"] = [
                "ok" => true,
                "message" => "Fallback ist gefunden"
            ];
        } else {
            $_SESSION["fallback_status"] = [
                "ok" => false,
                "message" => "Fallback nicht gefunden"
            ];
        }

    // 3. Fallback exestiert aber Keine DB-Verbindung
    //  

    // 4. Kein Fallback aber DB-Verbindung erfolgreich
    // alle daten in Fallback übertragen

    // 5. Kein Fallback und kein DB-Verbindung
    // neue Fallback erstellen mit Version 1

    // 6 Fallback exestiert und DB-Verbindung

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
