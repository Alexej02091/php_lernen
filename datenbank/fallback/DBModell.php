<?php
class DBModell {
    private DBName $dbname;
    private array $tabellen = [];
    
    public function __construct (DBName $dbname) {
        $this->dbname = $dbname;
    }

    public function addTabellen(DBTabellen $tabelle){
        $this->tabellen[] = $tabelle;
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

// class DBAttribut {
//     private Attributtname $attributname;
//     private Datentyp $datentyp;
//     private Laenge $laenge;
//     private Intergritaetsregel $intergritaetsregel;
//     private Automatisierung $automatisierung;

//     public function __construct (Attributtname $attributname, Datentyp $datentyp, Laenge $laenge, Intergritaetsregel $intergritaetsregel, Automatisierung $automatisierung) {
//         $this->attributname = $attributname;
//         $this->datentyp = $datentyp;
//         $this->laenge = $laenge;
//         $this->intergritaetsregel = $intergritaetsregel;
//         $this->automatisierung = $automatisierung;
//     }

// }

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
        return $this->$attributtname;
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
        return $this->$datentyp;
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
        return $this->$laenge;
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
        return $this->$intergritaetsregel;
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
        return $this->$automatisierung;
    }
}

class TabellenSchema {
    $attribut = new Attributtname;
    $datentyp = new Datentyp;
    $laenge = new Laenge;
    $intergritaetsregel = new Intergritaetsregel;
    $automatisierung = new Automatisierung;


    public function __construct(DBTabellenname $tabelleName, Attributtname $attribut, Datentyp $datentyp, Laenge $laenge, Intergritaetsregel $intergritaetsregel, Automatisierung $automatisierung) {
        $this->attribut = $attribut;
        $this->datentyp = $
    
        if ($tabelleName("users")){
                $this->attribut = "ID";
                $this->datentyp = "INT";
                $this->laenge = "";
                $this->intergritaetsregel = "Primary Key";
                $this->automatisierung = "AUTO_INCREMENT";
            }
    }

}

?>