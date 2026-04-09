<?php
include_once 'DBModell.php';

$dbName = new DBName("praktikum");
$usersTableName = new TabellenName("users");
$usersTable = new DBTabellen($usersTableName);

$idAttr = new DBAttribut(
    new Attributtname("ID"),
    new Datentyp("INT"),
    new Laenge(""),
    new Intergritaetsregel("Primary Key"),
    new Automatisierung("AUTO_INCREMENT")
);

$nameAttr = new DBAttribut(
    new Attributtname("name"),
    new Datentyp("VARCHAR"),
    new Laenge("255"),
    new Intergritaetsregel(""),
    new Automatisierung("")
);

$passwordAttr = new DBAttribut(
    new Attributtname("password"),
    new Datentyp("VARCHAR"),
    new Laenge("255"),
    new Intergritaetsregel(""),
    new Automatisierung("")
);

$rolleAttr = new DBAttribut(
    new Attributtname("rolle"),
    new Datentyp("VARCHAR"),
    new Laenge("255"),
    new Intergritaetsregel(""),
    new Automatisierung("")
);

$created_at = new DBAttribut(
    new Attributtname("created_at"),
    new Datentyp("TIMESTAMP"),
    new Laenge(""),
    new Intergritaetsregel(""),
    new Automatisierung("")
);

$usersTable->addAttribut($idAttr);
$usersTable->addAttribut($nameAttr);
$usersTable->addAttribut($passwordAttr);

$dbModell = new DBModell($dbName);

$dbModell->addTabellen($usersTable);

echo "<p>";
print_r($dbModell);
echo "</p>";
?>