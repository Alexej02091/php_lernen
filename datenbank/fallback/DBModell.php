<?php
class DBModell {
    private DBName $dbname;
    private array $tabellen = [];
    
    public function __construct(DBName $dbname) {
        $this->dbname = $dbname;

        // Automatisch Tabellen erzeugen abhängig vom DB-Namen
        $this->tabellen = match ($dbname->getdbName()) {

            "praktikum" => [
                new TabellenSchema("users"),
                // weitere Tabellen hier eintragen
            ],

            default => throw new InvalidArgumentException(
                "Für diese Datenbank existiert kein festes Schema: " . $dbname->getdbName()
            )
        };
    }

    public function getTabellen(): array {
        return $this->tabellen;
    }

}

class DBName {
    private string $dbName;

    private const ERLAUBT = ["praktikum"];

    public function __construct(string $dbName) {
        if (!in_array($dbName, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige DBName: $dbName");
        }
        $this->dbName = $dbName;
    }

    public function getdbName(): string {
        return $this->dbName;
    }
}

class DBTabellen {
    private TabellenName $tabelleName;
    private array $attribute = [];

    public function __construct (TabellenName $tabelleName) {
        $this->tabelleName = $tabelleName;
    }

    public function addAttribut(DBAttribut $attribute) {
        $this->attribute[] = $attribute;
    }
}

class DBAttribut {
    private Attributtname $name;
    private Datentyp $datentyp;
    private Laenge $laenge;
    private Intergritaetsregel $regel;
    private Automatisierung $auto;

    public function __construct(
        Attributtname $name,
        Datentyp $datentyp,
        Laenge $laenge,
        Intergritaetsregel $regel,
        Automatisierung $auto
    ) {
        $this->name = $name;
        $this->datentyp = $datentyp;
        $this->laenge = $laenge;
        $this->regel = $regel;
        $this->auto = $auto;
    }
}

class TabellenName {
    private string $tabellenname;

    private const ERLAUBT = ["users"];

    public function __construct(string $tabellenname) {
        if (!in_array($tabellenname, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Name der Tabelle: $tabellenname");
        }
        $this->tabellenname = $tabellenname;
    }

    public function getTabellenName(): string {
        return $this->tabellenname;
    }
}

class Attributtname {
    private string $attributtname;

    private const ERLAUBT = ["ID", "name", "password", "rolle", "created_at"];

    public function __construct(string $attributtname) {
        if (!in_array($attributtname, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Attribut: $attributtname");
        }
        $this->attributtname = $attributtname;
    }

    public function getAttributtName(): string {
        return $this->attributtname;
    }
}

class Datentyp {
    private string $datentyp;

    private const ERLAUBT = ["INT", "VARCHAR", "TIMESTAMP", ""];

    public function __construct(string $datentyp) {
        if (!in_array($datentyp, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Datentyp: $datentyp");
        }
        $this->datentyp = $datentyp;
    }

    public function getDatentyp(): string {
        return $this->datentyp;
    }
}

class Laenge {
    private string $laenge;

    private const ERLAUBT = ["255", ""];

    public function __construct(string $laenge) {
        if (!in_array($laenge, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Laenge: $laenge");
        }
        $this->laenge = $laenge;
    }

    public function getLaenge(): string {
        return $this->laenge;
    }
}

class Intergritaetsregel {
    private string $intergritaetsregel;

    private const ERLAUBT = ["NOT NULL", "Primary Key", "Foreign Key", ""];

    public function __construct(string $intergritaetsregel) {
        if (!in_array($intergritaetsregel, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Intergritaetsregel: $intergritaetsregel");
        }
        $this->intergritaetsregel = $intergritaetsregel;
    }

    public function getIntergritaetsregel(): string {
        return $this->intergritaetsregel;
    }
}

class Automatisierung {
    private string $automatisierung;

    private const ERLAUBT = ["AUTO_INCREMENT", ""];

    public function __construct(string $automatisierung) {
        if (!in_array($automatisierung, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Automatisierung: $automatisierung");
        }
        $this->automatisierung = $automatisierung;
    }

    public function getAutomatisierung(): string {
        return $this->automatisierung;
    }
}

class TabellenSchema {
    private string $tabelle;
    private array $attribute = [];

    public function __construct(string $tabelle) {
        $this->tabelle = $tabelle;
    
        $this->attribute = match ($tabelle) {
            "users" => [
                new DBAttribut(
                    new Attributtname("ID"),
                    new Datentyp("INT"),
                    new Laenge(""),
                    new Intergritaetsregel("Primary Key"),
                    new Automatisierung("AUTO_INCREMENT")
                ),
                new DBAttribut(
                    new Attributtname("name"),
                    new Datentyp("VARCHAR"),
                    new Laenge("255"),
                    new Intergritaetsregel("NOT NULL"),
                    new Automatisierung("")
                ),
                new DBAttribut(
                    new Attributtname("password"),
                    new Datentyp("VARCHAR"),
                    new Laenge("255"),
                    new Intergritaetsregel("NOT NULL"),
                    new Automatisierung("")
                ),
                new DBAttribut(
                    new Attributtname("rolle"),
                    new Datentyp("VARCHAR"),
                    new Laenge("255"),
                    new Intergritaetsregel("NOT NULL"),
                    new Automatisierung("")
                ),
                new DBAttribut(
                    new Attributtname("created_at"),
                    new Datentyp("TIMESTAMP"),
                    new Laenge(""),
                    new Intergritaetsregel("NOT NULL"),
                    new Automatisierung("")
                ),
                new DBAttribut(
                    new Attributtname("updated_at"),
                    new Datentyp("TIMESTAMP"),
                    new Laenge(""),
                    new Intergritaetsregel("NOT NULL"),
                    new Automatisierung("")
                ),
            ],

            default => throw new InvalidArgumentException("Unbekannte Tabelle: $tabelle")
        };
    }

    public function getAttribute(): array {
        return $this->attribute;
    }

}

?>