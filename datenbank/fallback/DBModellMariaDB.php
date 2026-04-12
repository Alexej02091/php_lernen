<?php

class SchemaDefinition {
    private SchemaName $schemaName;
    private array $tables = [];

    public function __construct(SchemaName $schemaName) {
        $this->schemaName = $schemaName;

        $this->tables = match ($schemaName->getName()) {

            "praktikum" => [
                new TableDefinition("users"),
            ],

            default => throw new InvalidArgumentException(
                "Kein festes Schema für Datenbank: " . $schemaName->getName()
            )
        };
    }

    public function getTables(): array {
        return $this->tables;
    }
}

class SchemaName {
    private string $name;

    private const ALLOWED = ["praktikum"];

    public function __construct(string $name) {
        if (!in_array($name, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültiger Datenbankname: $name");
        }
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}

class TableName {
    private string $name;

    private const ALLOWED = ["users"];

    public function __construct(string $name) {
        if (!in_array($name, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültiger Tabellenname: $name");
        }
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}

class ColumnName {
    private string $name;

    private const ALLOWED = ["ID", "name", "password", "rolle", "created_at", "updated_at"];

    public function __construct(string $name) {
        if (!in_array($name, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültiger Spaltenname: $name");
        }
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}

class DataType {
    private string $type;

    private const ALLOWED = ["INT", "VARCHAR", "TIMESTAMP", ""];

    public function __construct(string $type) {
        if (!in_array($type, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültiger Datentyp: $type");
        }
        $this->type = $type;
    }

    public function getType(): string {
        return $this->type;
    }
}

class CharacterMaximumLength {
    private string $length;

    private const ALLOWED = ["255", ""];

    public function __construct(string $length) {
        if (!in_array($length, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültige Länge: $length");
        }
        $this->length = $length;
    }

    public function getLength(): string {
        return $this->length;
    }
}

class IsNullableOrKey {
    private string $rule;

    private const ALLOWED = ["NOT NULL", "Primary Key", "Foreign Key", ""];

    public function __construct(string $rule) {
        if (!in_array($rule, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültige Regel: $rule");
        }
        $this->rule = $rule;
    }

    public function getRule(): string {
        return $this->rule;
    }
}

class Extra {
    private string $extra;

    private const ALLOWED = ["AUTO_INCREMENT", ""];

    public function __construct(string $extra) {
        if (!in_array($extra, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Ungültiges Extra: $extra");
        }
        $this->extra = $extra;
    }

    public function getExtra(): string {
        return $this->extra;
    }
}

class ColumnDefinition {
    private ColumnName $name;
    private DataType $type;
    private CharacterMaximumLength $length;
    private IsNullableOrKey $rule;
    private Extra $extra;

    public function __construct(
        ColumnName $name,
        DataType $type,
        CharacterMaximumLength $length,
        IsNullableOrKey $rule,
        Extra $extra
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->length = $length;
        $this->rule = $rule;
        $this->extra = $extra;
    }
}

class TableDefinition {
    private string $table;
    private array $columns = [];

    public function __construct(string $table) {
        $this->table = $table;

        $this->columns = match ($table) {

            "users" => [
                new ColumnDefinition(
                    new ColumnName("ID"),
                    new DataType("INT"),
                    new CharacterMaximumLength(""),
                    new IsNullableOrKey("Primary Key"),
                    new Extra("AUTO_INCREMENT")
                ),
                new ColumnDefinition(
                    new ColumnName("name"),
                    new DataType("VARCHAR"),
                    new CharacterMaximumLength("255"),
                    new IsNullableOrKey("NOT NULL"),
                    new Extra("")
                ),
                new ColumnDefinition(
                    new ColumnName("password"),
                    new DataType("VARCHAR"),
                    new CharacterMaximumLength("255"),
                    new IsNullableOrKey("NOT NULL"),
                    new Extra("")
                ),
                new ColumnDefinition(
                    new ColumnName("rolle"),
                    new DataType("VARCHAR"),
                    new CharacterMaximumLength("255"),
                    new IsNullableOrKey("NOT NULL"),
                    new Extra("")
                ),
                new ColumnDefinition(
                    new ColumnName("created_at"),
                    new DataType("TIMESTAMP"),
                    new CharacterMaximumLength(""),
                    new IsNullableOrKey("NOT NULL"),
                    new Extra("")
                ),
                new ColumnDefinition(
                    new ColumnName("updated_at"),
                    new DataType("TIMESTAMP"),
                    new CharacterMaximumLength(""),
                    new IsNullableOrKey("NOT NULL"),
                    new Extra("")
                ),
            ],

            default => throw new InvalidArgumentException("Unbekannte Tabelle: $table")
        };
    }

    public function getColumns(): array {
        return $this->columns;
    }
}

?>
