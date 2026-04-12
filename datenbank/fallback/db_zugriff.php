<?php

class MariaDBMetadata {

    private dbzugriff $db;

    public function __construct(dbzugriff $db) {
        $this->db = $db;
    }

    /**
     * Holt alle Tabellen der Datenbank
     */
    private function getTables(string $schemaName): array {
        $sql = "
            SELECT TABLE_NAME
            FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = '{$schemaName}'
        ";

        $result = $this->db->query($sql);

        if ($result === "" || $result === false) {
            return [];
        }

        $tables = [];

        // Einzelner Datensatz?
        if (isset($result['TABLE_NAME'])) {
            $tables[] = $result['TABLE_NAME'];
        } else {
            foreach ($result as $row) {
                $tables[] = $row['TABLE_NAME'];
            }
        }

        return $tables;
    }

    /**
     * Holt alle Spalten einer Tabelle
     */
    private function getColumns(string $schemaName, string $tableName): array {
        $sql = "
            SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH,
                   IS_NULLABLE, COLUMN_KEY, EXTRA
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '{$schemaName}'
              AND TABLE_NAME = '{$tableName}'
        ";

        $result = $this->db->query($sql);

        if ($result === "" || $result === false) {
            return [];
        }

        // Immer als Array zurückgeben
        if (isset($result['COLUMN_NAME'])) {
            return [$result];
        }

        return $result;
    }

    /**
     * Holt komplette Metadaten für die gesamte Datenbank
     */
    public function getMetadata(SchemaName $schemaName): array {

        $dbName = $schemaName->getName();

        $tables = $this->getTables($dbName);

        $metadata = [];

        foreach ($tables as $table) {
            $metadata[$table] = $this->getColumns($dbName, $table);
        }

        return $metadata;
    }
}

?>
