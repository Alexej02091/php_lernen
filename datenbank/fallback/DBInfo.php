<?php
class DBInfo {
    include_once 'DBModell.php';

    $bdname = new DBName("praktikum");
    $tabellen = array[];
    $attributen = array[];
    $eigenschaften = array[];

    function __construct(DBName $dbname, array $tabellen, array $attributen, array $eigenschaften) {
        $this->dbname = $dbname;
        $this->tabellen = $tabellen;
        $this->attributen = $attributen;
        $this->eigenschaften = $eigenschaften;
    }

    function holleAlleDatenbankInfo(){}
        
}
?>