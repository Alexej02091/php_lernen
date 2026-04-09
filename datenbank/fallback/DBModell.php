<?php
class DBModell {
    private TabellenNamen $tabelleName;
    private Attributtname $attributName;
    private Datentyp $datentyp;
    private Intergritätsregel $intergritätsregel;
    private Beziehugsmerkmale $beziehungsmerkmale;
    private Automatisierung $automatisierung;
    private Performance $performance;
    private String $dokumentation;
}

class TabellenNamen {
    private string $tabellenname;

    private const ERLAUBT = ["users"];

    public function __construct(string $tabellenname) {
        if (!in_array($tabellenname, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Name der Tabelle: $tabellenname");
        }
        $this->tabellenname = $tabellenname
    }

    public function getTabellenName(): string {
        return $this->$tabellenname;
    }
}

class Attributtname {
    private string $attributtname;

    private const ERLAUBT = ["ID",];

    public function __construct(string $attributtname) {
        if (!in_array($attributtname, self::ERLAUBT, true)) {
            throw new InvalidArgumentException("Ungültige Name der Tabelle: $attributtname");
        }
        $this->attributtname = $attributtname
    }

    public function getAttributtName(): string {
        return $this->$attributtname;
    }
}

?>