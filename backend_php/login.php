<?php
// Daten erhalten und in Variablen eingespeichert
$name = $_POST['name'] ?? '';
$password = $_POST['password'] ?? '';

//Datenbank verbindung
include_once('db_zugriff.php');
$db = new dbzugriff();
$db->connect();

//Name und Password checken
$sql = "SELECT ID FROM users WHERE name = $name and password = '" . password_hash($password, PASSWORD_DEFAULT) . "' LIMIT 1";

$name .= " bearbeitet";
$password .= " bearbeitet";


//Logincheck Klasse
class Logincheck {
    private $db;
    private $sql;
    private $daten;
    
    public function __construct() {
    } 
    
public function namePruefen($name) {
        include_once('db_zugriff.php');

        $this->db = new dbzugriff();
        $this->db->connect();
        $this->sql="SELECT  FROM users";
        $this->daten=$this->db->query($this->sql);
}
}

header("Location: ../index.php?name=$name&pass=$password");
exit;